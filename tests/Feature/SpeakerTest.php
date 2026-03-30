<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\Speaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SpeakerTest extends TestCase
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

    public function test_agenda_shows_live_speakers(): void
    {
        $live = Speaker::create([
            'name' => 'John Doe',
            'subtitle' => 'CEO, Acme Corp',
            'status' => 'live',
            'sort_order' => 1,
        ]);

        $draft = Speaker::create([
            'name' => 'Draft Speaker',
            'status' => 'draft',
            'sort_order' => 2,
        ]);

        $response = $this->withSession($this->authenticatedSession())
            ->get('/agenda');

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('CEO, Acme Corp');
        $response->assertDontSee('Draft Speaker');
    }

    public function test_agenda_hides_speaker_section_when_none_live(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->get('/agenda');

        $response->assertStatus(200);
        $response->assertDontSee('Our external guest speakers');
    }

    public function test_speaker_image_requires_login(): void
    {
        $speaker = Speaker::create([
            'name' => 'Test',
            'image_path' => 'speakers/test.jpg',
            'status' => 'live',
        ]);

        $this->get("/speakers/{$speaker->id}/image")->assertRedirect('/');
    }

    public function test_speaker_image_serves_live_file(): void
    {
        Storage::disk('local')->put('speakers/test.jpg', 'fake image');

        $speaker = Speaker::create([
            'name' => 'Test',
            'image_path' => 'speakers/test.jpg',
            'status' => 'live',
        ]);

        $response = $this->withSession($this->authenticatedSession())
            ->get("/speakers/{$speaker->id}/image");

        $response->assertStatus(200);

        Storage::disk('local')->delete('speakers/test.jpg');
    }

    public function test_speaker_image_blocked_for_draft(): void
    {
        $speaker = Speaker::create([
            'name' => 'Test',
            'image_path' => 'speakers/test.jpg',
            'status' => 'draft',
        ]);

        $response = $this->withSession($this->authenticatedSession())
            ->get("/speakers/{$speaker->id}/image");

        $response->assertStatus(404);
    }
}
