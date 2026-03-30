<?php

namespace Tests\Feature;

use App\Models\FormSubmission;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsAndSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_setting_get_and_set(): void
    {
        Setting::set('test_key', 'test_value');

        $this->assertEquals('test_value', Setting::get('test_key'));
    }

    public function test_setting_returns_default_when_missing(): void
    {
        $this->assertEquals('fallback', Setting::get('missing_key', 'fallback'));
    }

    public function test_setting_update_or_create(): void
    {
        Setting::set('my_key', 'first');
        Setting::set('my_key', 'second');

        $this->assertEquals('second', Setting::get('my_key'));
        $this->assertEquals(1, Setting::where('key', 'my_key')->count());
    }

    public function test_form_submission_stores_data(): void
    {
        $submission = FormSubmission::create([
            'form_slug' => FormSubmission::FORM_REGISTRATION,
            'data' => ['name' => 'Max', 'email' => 'max@test.de'],
        ]);

        $this->assertDatabaseHas('form_submissions', ['id' => $submission->id]);
        $this->assertEquals('Max', $submission->data['name']);
        $this->assertEquals('Registration', $submission->form_label);
    }

    public function test_form_submission_casts_data_to_array(): void
    {
        $submission = FormSubmission::create([
            'form_slug' => 'feedback',
            'data' => ['rating' => '5', 'comment' => 'Great event'],
        ]);

        $fresh = FormSubmission::find($submission->id);
        $this->assertIsArray($fresh->data);
        $this->assertEquals('5', $fresh->data['rating']);
    }
}
