<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\FormSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketInfoTest extends TestCase
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

    private function fullPayload(): array
    {
        return [
            'number_of_corrugators' => '15',
            'total_belt_market_size_m2' => '12000',
            'machine_width_lt_22' => '10',
            'machine_width_22_24' => '20',
            'machine_width_25_27' => '30',
            'machine_width_28_30' => '25',
            'machine_width_gt_30' => '15',
            'machine_speed_lt_60' => '50',
            'machine_speed_60_100' => '80',
            'machine_speed_100_150' => '120',
            'machine_speed_150_200' => '170',
            'machine_speed_200_300' => '250',
            'machine_speed_gt_300' => '320',
            'owner_groups_pct' => '60',
            'owner_independents_pct' => '40',
            'ms_market_share_pct' => '35',
            'competitor_a_name' => 'Comp A',
            'competitor_a_pct' => '25',
            'competitor_b_name' => 'Comp B',
            'competitor_b_pct' => '20',
            'competitor_c_name' => 'Comp C',
            'competitor_c_pct' => '10',
            'others_market_share_pct' => '10',
            'order_situation' => 'Stable',
            'price_level' => 'Rising',
            'capacity_utilization' => '80%',
            'machine_investments' => 'Increasing',
            'role_of_large_groups' => 'Dominant',
            'swot_strengths' => 'Quality',
            'swot_weaknesses' => 'Price',
            'swot_opportunities' => 'New segments',
            'swot_threats' => 'Asian players',
        ];
    }

    public function test_market_info_page_requires_login(): void
    {
        $this->get('/market-info')->assertRedirect('/');
    }

    public function test_market_info_page_loads(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->get('/market-info');

        $response->assertStatus(200);
        $response->assertSee('Market Overview');
        $response->assertSee('Market Share by Player');
        $response->assertSee('Market Situation');
        $response->assertSee('SWOT Overview');
    }

    public function test_full_submission_is_marked_complete(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->post('/market-info', $this->fullPayload());

        $response->assertRedirect('/market-info');
        $response->assertSessionHas('success');

        $submission = FormSubmission::where('form_slug', FormSubmission::FORM_MARKET_INFO)->first();
        $this->assertNotNull($submission);
        $this->assertTrue(FormSubmission::isMarketInfoComplete($submission->data));
        $this->assertEquals('35', $submission->data['ms_market_share_pct']);
        $this->assertEquals('Comp A', $submission->data['competitor_a_name']);
    }

    public function test_partial_submission_is_saved_with_warning(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->post('/market-info', [
                'ms_market_share_pct' => '35',
            ]);

        $response->assertRedirect('/market-info');
        $response->assertSessionHas('warning');
        $response->assertSessionMissing('errors');

        $submission = FormSubmission::where('form_slug', FormSubmission::FORM_MARKET_INFO)->first();
        $this->assertNotNull($submission);
        $this->assertEquals('35', $submission->data['ms_market_share_pct']);
        $this->assertFalse(FormSubmission::isMarketInfoComplete($submission->data));
    }

    public function test_delegation_is_marked_complete_without_filling_fields(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->post('/market-info', [
                'delegated' => 'true',
                'delegated_to' => 'Anna Colleague',
            ]);

        $response->assertRedirect('/market-info');
        $response->assertSessionHas('success');

        $submission = FormSubmission::where('form_slug', FormSubmission::FORM_MARKET_INFO)->first();
        $this->assertEquals('Anna Colleague', $submission->data['delegated_to']);
        $this->assertTrue(FormSubmission::isMarketInfoComplete($submission->data));
    }

    public function test_delegation_without_name_fails(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->post('/market-info', [
                'delegated' => 'true',
                'delegated_to' => '',
            ]);

        $response->assertRedirect('/market-info');
        $response->assertSessionHasErrors(['delegated_to']);
    }

    public function test_is_market_info_complete_helper(): void
    {
        $this->assertFalse(FormSubmission::isMarketInfoComplete([]));
        $this->assertTrue(FormSubmission::isMarketInfoComplete(['delegated_to' => 'Someone']));
        $this->assertTrue(FormSubmission::isMarketInfoComplete($this->fullPayload()));

        $partial = $this->fullPayload();
        unset($partial['swot_threats']);
        $this->assertFalse(FormSubmission::isMarketInfoComplete($partial));
    }

    public function test_csv_export_contains_new_fields_and_excludes_old(): void
    {
        $dealer = Dealer::create([
            'first_name' => 'Test',
            'last_name' => 'Dealer',
            'email' => 't@d.de',
            'pin' => '999999',
        ]);

        FormSubmission::create([
            'form_slug' => FormSubmission::FORM_MARKET_INFO,
            'dealer_id' => $dealer->id,
            'data' => array_merge($this->fullPayload(), [
                'first_name' => $dealer->first_name,
                'last_name' => $dealer->last_name,
            ]),
        ]);

        $admin = \App\Models\User::factory()->create();

        $response = $this->actingAs($admin)
            ->get('/admin/form-submissions');

        $response->assertStatus(200);
    }
}
