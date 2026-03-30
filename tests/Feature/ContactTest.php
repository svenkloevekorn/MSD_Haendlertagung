<?php

namespace Tests\Feature;

use App\Models\ContactPerson;
use App\Models\Dealer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    private function authenticatedSession(): array
    {
        $dealer = Dealer::create([
            'first_name' => 'Max',
            'last_name' => 'Test',
            'email' => 'max@test.de',
            'pin' => '123456',
        ]);

        return [
            'dealer_id' => $dealer->id,
            'dealer_logged_in_at' => now()->timestamp,
        ];
    }

    public function test_contact_page_requires_login(): void
    {
        $this->get('/kontakt')->assertRedirect('/');
    }

    public function test_contact_page_shows_live_persons(): void
    {
        ContactPerson::create([
            'name' => 'Jane Smith',
            'position' => 'Sales Manager',
            'email' => 'jane@example.com',
            'phone' => '+49 123 456',
            'status' => 'live',
            'sort_order' => 1,
        ]);

        ContactPerson::create([
            'name' => 'Draft Person',
            'status' => 'draft',
            'sort_order' => 2,
        ]);

        $response = $this->withSession($this->authenticatedSession())
            ->get('/kontakt');

        $response->assertStatus(200);
        $response->assertSee('Jane Smith');
        $response->assertSee('Sales Manager');
        $response->assertSee('jane@example.com');
        $response->assertSee('+49 123 456');
        $response->assertDontSee('Draft Person');
    }

    public function test_contact_image_requires_login(): void
    {
        $person = ContactPerson::create([
            'name' => 'Test',
            'image_path' => 'contact-persons/test.jpg',
            'status' => 'live',
        ]);

        $this->get("/kontakt/{$person->id}/image")->assertRedirect('/');
    }

    public function test_contact_image_serves_live_file(): void
    {
        Storage::disk('local')->put('contact-persons/test.jpg', 'fake image');

        $person = ContactPerson::create([
            'name' => 'Test',
            'image_path' => 'contact-persons/test.jpg',
            'status' => 'live',
        ]);

        $response = $this->withSession($this->authenticatedSession())
            ->get("/kontakt/{$person->id}/image");

        $response->assertStatus(200);

        Storage::disk('local')->delete('contact-persons/test.jpg');
    }
}
