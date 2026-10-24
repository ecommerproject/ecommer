<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class AccountAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_login_and_registration_pages_from_account_link(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('href="'.route('login').'"', false);

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('ចូលគណនីរបស់អ្នក')
            ->assertSee('បន្តជាមួយ Google');

        $this->get(route('register'))
            ->assertOk()
            ->assertSee('បង្កើតគណនីរបស់អ្នក')
            ->assertSee('បន្តជាមួយ Google');
    }

    public function test_signed_in_user_account_link_opens_their_account(): void
    {
        $user = User::factory()->create(['name' => 'Dara Shopper']);

        $this->actingAs($user)
            ->get('/')
            ->assertOk()
            ->assertSee('href="'.route('account.show').'"', false)
            ->assertSee('Dara Shopper');
    }

    public function test_user_can_register_and_view_their_protected_account(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Dara Shopper',
            'email' => 'dara@example.com',
            'password' => 'safe-password-123',
            'password_confirmation' => 'safe-password-123',
        ]);

        $response->assertRedirect(route('account.show'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'dara@example.com']);
        $this->assertTrue(Hash::check('safe-password-123', User::where('email', 'dara@example.com')->value('password')));

        $this->get(route('account.show'))
            ->assertOk()
            ->assertSee('សូមស្វាគមន៍មកកាន់គណនីរបស់អ្នក')
            ->assertSee('dara@example.com');
    }

    public function test_user_can_sign_in_and_sign_out(): void
    {
        $user = User::factory()->create([
            'email' => 'shopper@example.com',
            'password' => 'safe-password-123',
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'safe-password-123',
            'remember' => '1',
        ])->assertRedirect(route('account.show'));

        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))
            ->assertRedirect(route('store.home'));

        $this->assertGuest();
    }

    public function test_invalid_credentials_and_duplicate_registration_are_rejected(): void
    {
        User::factory()->create([
            'email' => 'shopper@example.com',
            'password' => 'safe-password-123',
        ]);

        $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => 'shopper@example.com',
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->post(route('register.store'), [
            'name' => 'Another Shopper',
            'email' => 'shopper@example.com',
            'password' => 'safe-password-123',
            'password_confirmation' => 'different-password',
        ])->assertSessionHasErrors(['email', 'password']);

        $this->get(route('account.show'))
            ->assertRedirect(route('login'));
    }

    public function test_google_redirect_requires_oauth_configuration(): void
    {
        config([
            'services.google.client_id' => null,
            'services.google.client_secret' => null,
        ]);

        $this->get(route('google.redirect'))
            ->assertRedirect(route('login'));

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('មិនទាន់បានកំណត់ Google Sign-In ទេ។');
    }

    public function test_verified_google_user_can_register_and_sign_in(): void
    {
        config([
            'services.google.client_id' => 'test-client',
            'services.google.client_secret' => 'test-secret',
            'services.google.redirect' => route('google.callback'),
        ]);

        $googleUser = new SocialiteUser;
        $googleUser->id = 'google-user-123';
        $googleUser->name = 'Google Shopper';
        $googleUser->email = 'google@example.com';
        $googleUser->setRaw(['verified_email' => true]);

        $provider = \Mockery::mock();
        $provider->shouldReceive('user')->once()->andReturn($googleUser);
        Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

        $this->get(route('google.callback', ['code' => 'oauth-code', 'state' => 'oauth-state']))
            ->assertRedirect(route('account.show'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'google_id' => 'google-user-123',
            'email' => 'google@example.com',
        ]);
        $this->assertNotNull(User::where('email', 'google@example.com')->value('email_verified_at'));
    }

    public function test_google_sign_in_rejects_unverified_email(): void
    {
        config([
            'services.google.client_id' => 'test-client',
            'services.google.client_secret' => 'test-secret',
            'services.google.redirect' => route('google.callback'),
        ]);

        $googleUser = new SocialiteUser;
        $googleUser->id = 'google-user-unverified';
        $googleUser->name = 'Unverified Shopper';
        $googleUser->email = 'unverified@example.com';
        $googleUser->setRaw(['verified_email' => false]);

        $provider = \Mockery::mock();
        $provider->shouldReceive('user')->once()->andReturn($googleUser);
        Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

        $this->get(route('google.callback', ['code' => 'oauth-code', 'state' => 'oauth-state']))
            ->assertRedirect(route('login'));

        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['email' => 'unverified@example.com']);
    }
}
