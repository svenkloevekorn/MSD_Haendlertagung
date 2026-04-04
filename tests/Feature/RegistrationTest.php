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
                'mobile' => '+49 123 456',
                'company' => 'Acme Corp',
            ]);

        $response->assertRedirect('/formular');
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('form_submissions', 1);
        $submission = FormSubmission::first();
        $this->assertEquals('registration', $submission->form_slug);
        $this->assertEquals('Max', $submission->data['first_name']);
        $this->assertEquals('max@test.de', $submission->data['email']);
    }

    public function test_registration_updates_existing_submission(): void
    {
        $session = $this->authenticatedSession();

        $this->withSession($session)->post('/formular', ['mobile' => '+49 111']);
        $this->assertDatabaseCount('form_submissions', 1);

        $this->withSession($session)->post('/formular', ['mobile' => '+49 222']);
        $this->assertDatabaseCount('form_submissions', 1);

        $submission = FormSubmission::first();
        $this->assertEquals('+49 222', $submission->data['mobile']);
    }

    public function test_registration_loads_saved_data(): void
    {
        $session = $this->authenticatedSession();

        $this->withSession($session)->post('/formular', ['mobile' => '+49 333', 'company' => 'Test Corp']);

        $response = $this->withSession($session)->get('/formular');
        $response->assertSee('+49 333');
        $response->assertSee('Test Corp');
    }

    public function test_registration_shows_confirmation_from_settings(): void
    {
        Setting::set('confirmation_registration', 'Custom thank you message!');

        $session = $this->authenticatedSession();

        $response = $this->withSession($session)
            ->post('/formular', [
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
                'mobile' => '+49 111',
                'companion_mobile' => '+49 222',
                'allergies' => 'Nuts',
                'factory_tour' => 'yes',
                'comments' => 'Looking forward!',
            ]);

        $submission = FormSubmission::first();
        $this->assertEquals('+49 222', $submission->data['companion_mobile']);
        $this->assertEquals('yes', $submission->data['factory_tour']);
        $this->assertEquals('Nuts', $submission->data['allergies']);
    }
}
