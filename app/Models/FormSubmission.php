<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormSubmission extends Model
{
    protected $fillable = [
        'form_slug',
        'dealer_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public const FORM_REGISTRATION = 'registration';
    public const FORM_FEEDBACK = 'feedback';
    public const FORM_MARKET_INFO = 'market_info';

    public static array $formLabels = [
        self::FORM_REGISTRATION => 'Registration',
        self::FORM_FEEDBACK => 'Feedback',
        self::FORM_MARKET_INFO => 'Market Info',
    ];

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function getFormLabelAttribute(): string
    {
        return self::$formLabels[$this->form_slug] ?? $this->form_slug;
    }

    public const MARKET_INFO_REQUIRED_FIELDS = [
        'number_of_corrugators',
        'total_belt_market_size_m2',
        'machine_width_lt_22',
        'machine_width_22_24',
        'machine_width_25_27',
        'machine_width_28_30',
        'machine_width_gt_30',
        'machine_speed_lt_60',
        'machine_speed_60_100',
        'machine_speed_100_150',
        'machine_speed_150_200',
        'machine_speed_200_300',
        'machine_speed_gt_300',
        'owner_groups_pct',
        'owner_independents_pct',
        'ms_market_share_pct',
        'competitor_a_name', 'competitor_a_pct',
        'competitor_b_name', 'competitor_b_pct',
        'competitor_c_name', 'competitor_c_pct',
        'others_market_share_pct',
        'order_situation', 'price_level', 'capacity_utilization',
        'machine_investments', 'role_of_large_groups',
        'swot_strengths', 'swot_weaknesses', 'swot_opportunities', 'swot_threats',
    ];

    public static function isMarketInfoComplete(array $data): bool
    {
        if (! empty($data['delegated_to'] ?? null)) {
            return true;
        }
        foreach (self::MARKET_INFO_REQUIRED_FIELDS as $field) {
            if (($data[$field] ?? '') === '' || ($data[$field] ?? null) === null) {
                return false;
            }
        }
        return true;
    }
}
