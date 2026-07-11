<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorPageView extends Model
{
    protected $fillable = [
        'visitor_session_id',
        'path',
        'title',
        'started_at',
        'ended_at',
        'duration_seconds',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'duration_seconds' => 'integer',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(VisitorSession::class, 'visitor_session_id');
    }
}
