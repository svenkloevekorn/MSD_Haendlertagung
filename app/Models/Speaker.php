<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Speaker extends Model
{
    protected $fillable = [
        'name',
        'subtitle',
        'image_path',
        'status',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Speaker $speaker) {
            if ($speaker->image_path) {
                Storage::disk('local')->delete($speaker->image_path);
            }
        });
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }
}
