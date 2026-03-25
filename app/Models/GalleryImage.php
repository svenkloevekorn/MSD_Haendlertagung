<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'original_filename',
        'file_size',
        'status',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::saving(function (GalleryImage $image) {
            if ($image->image_path && Storage::disk('local')->exists($image->image_path)) {
                $image->file_size = Storage::disk('local')->size($image->image_path);
            }
        });

        static::deleting(function (GalleryImage $image) {
            if ($image->image_path) {
                Storage::disk('local')->delete($image->image_path);
            }
        });
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }
}
