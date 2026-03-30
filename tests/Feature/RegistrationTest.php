<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\FormSubmission;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
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

    public function test_registration_page_requires_login(): void
    {
        $this->get('/formular')->assertRedirect('/');
    }

    public function test_registration_page_loads(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->get('/formular');

        $response->assertStatus(200);
        $response->assertSee('Registration');
        $response->assertSee('Personal Details');
    }

    public function test_registration_submit_stores_submission(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->post('/formular', [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'mobile' => '+49 123 456',
                'company' => 'Acme Corp',
            ]);

        $response->assertRedirect('/formular');
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('form_submissions', 1);
        $submission = FormSubmission::first();
        $this->assertEquals('registration', $submission->form_slug);
        $this->assertEquals('John', $submission->data['first_name']);
        $this->assertEquals('john@example.com', $submission->data['email']);
    }

    public function test_registration_validates_required_fields(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->post('/formular', []);

        $response->assertSessionHasErrors(['first_name', 'last_name', 'email', 'mobile']);
        $this->assertDatabaseCount('form_submissions', 0);
    }

    public function test_registration_shows_confirmation_from_settings(): void
    {
        Setting::set('confirmation_registration', 'Custom thank you message!');

        $session = $this->authenticatedSession();

        $response = $this->withSession($session)
            ->post('/formular', [
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'jane@example.com',
                'mobile' => '+49 999',
            ]);

        $response->assertRedirect('/formular');

        $follow = $this->withSession($session)
            ->get('/formular');

        $follow->assertSee('Custom thank you message!');
    }

    public function test_registration_stores_optional_fields(): void
    {
        $this->withSession($this->authenticatedSession())
            ->post('/formular', [
                'first_name' => 'Max',
                'last_name' => 'Muster',
                'email' => 'max@muster.de',
                'mobile' => '+49 111',
                'has_companion' => '1',
                'companion_first_name' => 'Anna',
                'companion_last_name' => 'Muster',
                'allergies' => 'Nuts',
                'factory_tour' => '1',
                'whatsapp' => '1',
                'comments' => 'Looking forward!',
            ]);

        $submission = FormSubmission::first();
        $this->assertTrue($submission->data['has_companion']);
        $this->assertEquals('Anna', $submission->data['companion_first_name']);
        $this->assertTrue($submission->data['factory_tour']);
        $this->assertEquals('Nuts', $submission->data['allergies']);
    }
}
