<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ContactPerson extends Model
{
    protected $table = 'contact_persons';

    protected $fillable = [
        'name',
        'position',
        'email',
        'phone',
        'phone_link',
        'image_path',
        'status',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::deleting(function (ContactPerson $person) {
            if ($person->image_path) {
                Storage::disk('local')->delete($person->image_path);
            }
        });
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }
}
