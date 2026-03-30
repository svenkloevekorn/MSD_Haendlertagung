<?php

namespace Tests\Feature;

use App\Models\AgendaDay;
use App\Models\Dealer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgendaTest extends TestCase
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

    public function test_agenda_page_requires_login(): void
    {
        $this->get('/agenda')->assertRedirect('/');
    }

    public function test_agenda_page_shows_days_from_database(): void
    {
        $day = AgendaDay::create([
            'tab_label' => 'Mo, 29.06.',
            'date' => '2026-06-29',
            'title' => 'Montag – Anreisetag',
            'subtitle' => '29. Juni 2026',
            'sort_order' => 1,
        ]);

        $day->items()->createMany([
            ['overline' => 'Nachmittag', 'title' => 'Check-in im Hotel', 'description' => 'Ankunft im Hotel Lago', 'sort_order' => 1],
            ['overline' => '19:00 Uhr', 'title' => 'Gemeinsames Abendessen', 'sort_order' => 2],
        ]);

        $response = $this->withSession($this->authenticatedSession())
            ->get('/agenda');

        $response->assertStatus(200);
        $response->assertSee('Mo, 29.06.');
        $response->assertSee('Montag – Anreisetag');
        $response->assertSee('Check-in im Hotel');
        $response->assertSee('Ankunft im Hotel Lago');
        $response->assertSee('Gemeinsames Abendessen');
    }

    public function test_agenda_page_shows_partnerprogramm_tab(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->get('/agenda');

        $response->assertStatus(200);
        $response->assertSee('Partner Programme');
    }

    public function test_agenda_page_shows_multiple_days_in_order(): void
    {
        AgendaDay::create([
            'tab_label' => 'Di, 30.06.',
            'date' => '2026-06-30',
            'title' => 'Dienstag – Tag 1',
            'sort_order' => 2,
        ]);

        AgendaDay::create([
            'tab_label' => 'Mo, 29.06.',
            'date' => '2026-06-29',
            'title' => 'Montag – Anreisetag',
            'sort_order' => 1,
        ]);

        $response = $this->withSession($this->authenticatedSession())
            ->get('/agenda');

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Mo, 29.06.', 'Di, 30.06.']);
    }
}
