<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgendaDay extends Model
{
    protected $fillable = [
        'tab_label',
        'date',
        'title',
        'subtitle',
        'sort_order',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(AgendaItem::class)->orderBy('sort_order');
    }
}
