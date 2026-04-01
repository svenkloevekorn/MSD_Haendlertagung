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

    public static array $formLabels = [
        self::FORM_REGISTRATION => 'Registration',
        self::FORM_FEEDBACK => 'Feedback',
    ];

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function getFormLabelAttribute(): string
    {
        return self::$formLabels[$this->form_slug] ?? $this->form_slug;
    }
}
