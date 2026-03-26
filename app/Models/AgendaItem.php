<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgendaItem extends Model
{
    protected $fillable = [
        'agenda_day_id',
        'overline',
        'title',
        'description',
        'sort_order',
    ];

    public function day(): BelongsTo
    {
        return $this->belongsTo(AgendaDay::class, 'agenda_day_id');
    }
}
