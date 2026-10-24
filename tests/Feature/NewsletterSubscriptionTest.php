<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class NewsletterSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_valid_email_is_saved_as_a_newsletter_subscriber(): void
    {
        $response = $this->postJson(route('newsletter.subscribe'), [
            'email' => 'shopper@example.com',
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('message', 'អរគុណ! អ្នកបានចុះឈ្មោះជោគជ័យ។');

        $this->assertDatabaseHas('newsletter_subscribers', [
            'email' => 'shopper@example.com',
        ]);
    }

    public function test_invalid_and_duplicate_emails_are_rejected(): void
    {
        $this->postJson(route('newsletter.subscribe'), [
            'email' => 'not-an-email',
        ])->assertUnprocessable();

        DB::table('newsletter_subscribers')->insert([
            'email' => 'shopper@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->postJson(route('newsletter.subscribe'), [
            'email' => 'shopper@example.com',
        ])
            ->assertUnprocessable()
            ->assertJsonPath('errors.email.0', 'អ៊ីមែលនេះបានចុះឈ្មោះរួចហើយ។');
    }
}
