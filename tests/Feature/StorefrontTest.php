<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_store_displays_in_khmer_by_default(): void
    {
        $response = $this->get('/')
            ->assertOk()
            ->assertSee('ទំនិញពេញនិយម')
            ->assertSee('ភាសា')
            ->assertSee('តម្រៀបទំនិញ')
            ->assertSee('តែទំនិញចំណូលចិត្ត')
            ->assertSee('កាបូបស្ពាយប្រចាំថ្ងៃ');

        $this->assertSame(8, substr_count($response->getContent(), 'class="product-card"'));
    }

    public function test_the_products_navigation_opens_a_catalog_with_every_product(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('store.products'), false);

        $response = $this->get(route('store.products'))
            ->assertOk()
            ->assertSee('ស្វែងរកផលិតផលដែលអ្នកចូលចិត្ត')
            ->assertSee('កាសស្តាប់ត្រចៀកឥតខ្សែ')
            ->assertSee('កែវកាហ្វេ Ceramic ស្អាត')
            ->assertSee('id="product-sort"', false)
            ->assertSee('class="wishlist-filter"', false);

        $this->assertSame(8, substr_count($response->getContent(), 'class="product-card"'));
    }

    public function test_new_arrivals_navigation_opens_a_catalog_of_new_products(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('store.new-arrivals'), false);

        $response = $this->get(route('store.new-arrivals'))
            ->assertOk()
            ->assertSee('ទំនិញថ្មីសម្រាប់អ្នក')
            ->assertSee('ទំនិញថ្មី')
            ->assertSee('កាមេរ៉ា Compact ច្បាស់កម្រិតខ្ពស់')
            ->assertSee('aria-current="page">ទំនិញថ្មី</span>', false)
            ->assertSee(route('store.new-arrivals'), false)
            ->assertDontSee('កាបូបស្ពាយប្រចាំថ្ងៃ');

        $this->assertSame(4, substr_count($response->getContent(), 'class="product-card"'));

        $this->get(route('store.new-arrivals', ['lang' => 'en']))
            ->assertOk()
            ->assertSee('New just for you')
            ->assertSee('High-resolution compact camera')
            ->assertDontSee('Modern wristwatch');
    }

    public function test_about_navigation_opens_the_about_page_in_both_languages(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('store.about'), false);

        $this->get(route('store.about'))
            ->assertOk()
            ->assertSee('អំពីយើង')
            ->assertSee('ស្វែងរកទំនិញល្អៗសម្រាប់រាល់ថ្ងៃ')
            ->assertSee('ជ្រើសរើសគុណភាពដោយយកចិត្តទុកដាក់')
            ->assertSee('class="nav-item active" href="'.route('store.about').'"', false);

        $this->get(route('store.about', ['lang' => 'en']))
            ->assertOk()
            ->assertSee('About Us | Dara Market')
            ->assertSee('Good finds for everyday life')
            ->assertSee('Thoughtful quality');
    }

    public function test_contact_navigation_opens_a_contact_page_with_working_contact_links(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('store.contact'), false);

        $this->get(route('store.contact'))
            ->assertOk()
            ->assertSee('ទាក់ទងមកយើង')
            ->assertSee('href="tel:+85512345678"', false)
            ->assertSee('href="mailto:hello@daramarket.com"', false)
            ->assertSee('ភ្នំពេញ ប្រទេសកម្ពុជា')
            ->assertSee('class="nav-item active" href="'.route('store.contact').'"', false);

        $this->get(route('store.contact', ['lang' => 'en']))
            ->assertOk()
            ->assertSee('Contact Us | Dara Market')
            ->assertSee('Get in touch')
            ->assertSee('Phnom Penh, Cambodia');
    }

    public function test_search_returns_matching_products_and_keeps_the_query_in_the_search_box(): void
    {
        $response = $this->get(route('store.products', ['lang' => 'en', 'q' => 'headphones']))
            ->assertOk()
            ->assertSee('action="'.route('store.products').'"', false)
            ->assertSee('name="q"', false)
            ->assertSee('value="headphones"', false)
            ->assertSee('Wireless headphones')
            ->assertDontSee('Modern wristwatch');

        $this->assertSame(1, substr_count($response->getContent(), 'class="product-card"'));
    }

    public function test_the_categories_navigation_opens_categories_and_filters_products(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('store.categories'), false);

        $this->get(route('store.categories'))
            ->assertOk()
            ->assertSee('ស្វែងរកទំនិញតាមប្រភេទ')
            ->assertSee('អេឡិចត្រូនិក')
            ->assertSee('ម៉ូដ និងគ្រឿងបន្ថែម')
            ->assertSee(route('store.products', ['category' => 'electronics']), false);

        $response = $this->get(route('store.products', ['category' => 'electronics']))
            ->assertOk()
            ->assertSee('data-selected-category="electronics"', false)
            ->assertSee('data-filter="electronics"', false);

        $this->assertSame(8, substr_count($response->getContent(), 'class="product-card"'));
        $this->assertSame(3, substr_count($response->getContent(), 'data-category="electronics"'));
    }

    public function test_the_language_can_be_changed_and_is_remembered(): void
    {
        $this->get('/?lang=en')
            ->assertOk()
            ->assertSee('Popular products')
            ->assertSee('Everyday backpack')
            ->assertSee('Shop by category')
            ->assertSee('Sort products')
            ->assertSee('Saved only');

        $this->get('/')
            ->assertOk()
            ->assertSee('Popular products')
            ->assertSee('Everyday backpack');
    }

    public function test_unsupported_languages_do_not_replace_the_selected_language(): void
    {
        $this->get('/?lang=en')->assertOk();

        $this->get('/?lang=fr')
            ->assertOk()
            ->assertSee('Popular products');
    }
}
