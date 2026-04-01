<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'salutation',
        'country',
        'pin',
        'last_login_at',
    ];

    public function setPinAttribute(string $value): void
    {
        $this->attributes['pin'] = strtoupper($value);
    }

    protected function casts(): array
    {
        return [
            'last_login_at' => 'datetime',
        ];
    }
}
