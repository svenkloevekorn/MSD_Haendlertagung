<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Download extends Model
{
    protected $fillable = [
        'name',
        'description',
        'file_path',
        'original_filename',
        'file_size',
        'status',
        'sort_order',
    ];

    protected static function booted(): void
    {
        static::saving(function (Download $download) {
            if ($download->file_path && Storage::disk('local')->exists($download->file_path)) {
                $download->file_size = Storage::disk('local')->size($download->file_path);
            }
        });

        static::deleting(function (Download $download) {
            if ($download->file_path) {
                Storage::disk('local')->delete($download->file_path);
            }
        });
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function getFileExtensionAttribute(): string
    {
        return strtolower(pathinfo($this->original_filename, PATHINFO_EXTENSION));
    }

    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size;

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }

        return round($bytes / 1024) . ' KB';
    }
}
