<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\FormSubmission;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackTest extends TestCase
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

    public function test_feedback_page_requires_login(): void
    {
        $this->get('/feedback')->assertRedirect('/');
    }

    public function test_feedback_page_loads(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->get('/feedback');

        $response->assertStatus(200);
        $response->assertSee('Feedback');
        $response->assertSee('Overall Impression');
    }

    public function test_feedback_submit_stores_submission(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->post('/feedback', [
                'rating' => '5',
                'liked' => 'Great networking',
                'improve' => 'More breaks',
            ]);

        $response->assertRedirect('/feedback');
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('form_submissions', 1);
        $submission = FormSubmission::first();
        $this->assertEquals('feedback', $submission->form_slug);
        $this->assertEquals('5', $submission->data['rating']);
        $this->assertEquals('Great networking', $submission->data['liked']);
    }

    public function test_feedback_validates_rating_required(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->post('/feedback', []);

        $response->assertSessionHasErrors(['rating']);
        $this->assertDatabaseCount('form_submissions', 0);
    }

    public function test_feedback_shows_confirmation_from_settings(): void
    {
        Setting::set('confirmation_feedback', 'Thanks for your feedback!');
        $session = $this->authenticatedSession();

        $this->withSession($session)->post('/feedback', ['rating' => '4']);

        $follow = $this->withSession($session)->get('/feedback');
        $follow->assertSee('Thanks for your feedback!');
    }
}
