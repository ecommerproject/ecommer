<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_is_public_but_management_requires_admin_access(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dara Market today')
            ->assertSee('Total products')
            ->assertSee('Products')
            ->assertSee('Customers')
            ->assertSee('Newsletter')
            ->assertSee('Store owner?')
            ->assertSee(route('admin.products.index'))
            ->assertSee(route('admin.customers.index'))
            ->assertSee(route('admin.subscribers.index'))
            ->assertSee('Admin sign in')
            ->assertDontSee('Newsletter subscribers')
            ->assertDontSee('Customer accounts')
            ->assertDontSee('Add product');

        $this->get('/dashborad')
            ->assertRedirect(route('admin.dashboard'));

        $this->get('/AdminDashboardTest.php')
            ->assertRedirect(route('admin.dashboard'));

        $this->get(route('admin.products.index'))
            ->assertRedirect(route('login'));

        $this->get(route('admin.subscribers.index'))
            ->assertRedirect(route('login'));

        $this->get(route('admin.customers.index'))
            ->assertRedirect(route('login'));

        $this->get(route('admin.report.export'))
            ->assertRedirect(route('login'));

        $regularUser = User::factory()->create();
        $this->actingAs($regularUser)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertDontSee('Newsletter subscribers');

        $this->get(route('admin.products.index'))
            ->assertForbidden();

        $this->get(route('admin.subscribers.index'))
            ->assertForbidden();

        $this->get(route('admin.customers.index'))
            ->assertForbidden();

        $this->get(route('admin.report.export'))
            ->assertForbidden();
    }

    public function test_admin_dashboard_urls_redirect_to_the_admin_dashboard(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)
            ->get('/dashborad')
            ->assertRedirect(route('admin.dashboard'));

        $this->get('/dashboard')
            ->assertRedirect(route('admin.dashboard'));

        $this->get('/AdminDashboardTest.php')
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_can_open_dashboard_and_manage_store_products(): void
    {
        $admin = User::factory()->create(['name' => 'Store Admin']);
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dara Market today')
            ->assertSee('Total products')
            ->assertSee('Newsletter subscribers')
            ->assertSee('Customer accounts')
            ->assertSee('Activity overview')
            ->assertSee('Products by category')
            ->assertSee('Top rated products')
            ->assertSee('Export report');

        $this->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('Everyday backpack')
            ->assertSee('កាបូបស្ពាយប្រចាំថ្ងៃ')
            ->assertSee('Search products');

        $this->get(route('admin.products.index', ['q' => 'headphones', 'status' => 'active']))
            ->assertOk()
            ->assertSee('Wireless headphones')
            ->assertDontSee('Everyday backpack');

        $this->post(route('admin.products.store'), [
            'name_en' => 'Admin Test Product',
            'name_km' => 'ផលិតផលសាកល្បង',
            'category' => 'electronics',
            'price' => '24.50',
            'old_price' => '30',
            'rating' => '4.5',
            'image_url' => 'https://example.com/admin-test-product.jpg',
            'badge' => 'New',
            'sort_order' => 30,
            'is_active' => '1',
            'is_new' => '1',
        ])->assertRedirect(route('admin.products.index'));

        $product = Product::query()->where('name_en', 'Admin Test Product')->firstOrFail();
        $this->assertTrue($product->is_active);
        $this->assertTrue($product->is_new);

        $this->get(route('store.products', ['lang' => 'en']))
            ->assertOk()
            ->assertSee('Admin Test Product');

        $this->put(route('admin.products.update', $product), [
            'name_en' => 'Updated Admin Product',
            'name_km' => 'ផលិតផលបានកែប្រែ',
            'category' => 'kitchen',
            'price' => '20',
            'old_price' => '',
            'rating' => '5',
            'image_url' => 'https://example.com/updated-admin-product.jpg',
            'badge' => '',
            'sort_order' => 31,
        ])->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name_en' => 'Updated Admin Product',
            'category' => 'kitchen',
            'is_new' => false,
            'is_active' => false,
        ]);

        $this->get(route('store.products', ['lang' => 'en']))
            ->assertOk()
            ->assertDontSee('Updated Admin Product');

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_admin_can_review_newsletter_subscribers(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        DB::table('newsletter_subscribers')->insert([
            'email' => 'customer@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.subscribers.index'))
            ->assertOk()
            ->assertSee('Newsletter subscribers')
            ->assertSee('customer@example.com');

        $subscriberId = DB::table('newsletter_subscribers')
            ->where('email', 'customer@example.com')
            ->value('id');

        $this->delete(route('admin.subscribers.destroy', $subscriberId))
            ->assertRedirect(route('admin.subscribers.index'));

        $this->assertDatabaseMissing('newsletter_subscribers', ['email' => 'customer@example.com']);
    }

    public function test_admin_can_export_inventory_report_with_safe_csv_values(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $product = Product::query()->firstOrFail();
        $product->update(['name_en' => '=1+1']);

        $response = $this->actingAs($admin)->get(route('admin.report.export'));

        $response->assertDownload('dara-market-inventory-'.now()->format('Y-m-d').'.csv');
        $this->assertStringContainsString('Dara Market inventory report', $response->streamedContent());
        $this->assertStringContainsString("'=1+1", $response->streamedContent());
        $this->assertStringContainsString('Visible products', $response->streamedContent());
    }

    public function test_admin_can_search_update_and_delete_customer_accounts_without_touching_admins(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $customer = User::factory()->create([
            'name' => 'Customer One',
            'email' => 'customer-one@example.com',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.customers.index', ['q' => 'customer-one']))
            ->assertOk()
            ->assertSee('Customer One')
            ->assertDontSee($admin->email);

        $this->put(route('admin.customers.update', $customer), [
            'name' => 'Updated Customer',
            'email' => 'updated-customer@example.com',
        ])->assertRedirect(route('admin.customers.index'));

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'name' => 'Updated Customer',
            'email' => 'updated-customer@example.com',
            'email_verified_at' => null,
        ]);

        $this->delete(route('admin.customers.destroy', $customer))
            ->assertRedirect(route('admin.customers.index'));

        $this->assertDatabaseMissing('users', ['id' => $customer->id]);

        $this->put(route('admin.customers.update', $admin), [
            'name' => 'Changed Admin',
            'email' => $admin->email,
        ])->assertNotFound();

        $this->delete(route('admin.customers.destroy', $admin))
            ->assertNotFound();
    }

    public function test_console_command_can_promote_an_existing_user_to_admin(): void
    {
        $user = User::factory()->create(['email' => 'owner@example.com']);

        $this->artisan('store:make-admin', ['email' => $user->email])
            ->expectsOutputToContain('Administrator access granted')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_admin' => true,
        ]);
    }
}
