<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = [
        'form_slug',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public const FORM_REGISTRATION = 'registration';
    public const FORM_FEEDBACK = 'feedback';
    public const FORM_CONTACT = 'contact';

    public static array $formLabels = [
        self::FORM_REGISTRATION => 'Registration',
        self::FORM_FEEDBACK => 'Feedback',
        self::FORM_CONTACT => 'Contact',
    ];

    public function getFormLabelAttribute(): string
    {
        return self::$formLabels[$this->form_slug] ?? $this->form_slug;
    }
}
