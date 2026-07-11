<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VisitorSession extends Model
{
    protected $fillable = [
        'visitor_uuid',
        'ip_address',
        'country',
        'region',
        'city',
        'email',
        'name',
        'user_agent',
        'browser',
        'platform',
        'device',
        'landing_page',
        'referrer',
        'page_views_count',
        'events_count',
        'total_duration_seconds',
        'first_seen_at',
        'last_seen_at',
    ];

    protected function casts(): array
    {
        return [
            'first_seen_at' => 'datetime',
            'last_seen_at' => 'datetime',
            'page_views_count' => 'integer',
            'events_count' => 'integer',
            'total_duration_seconds' => 'integer',
        ];
    }

    public function pageViews(): HasMany
    {
        return $this->hasMany(VisitorPageView::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(VisitorEvent::class);
    }

    public function getLocationLabelAttribute(): string
    {
        $parts = array_filter([$this->city, $this->region, $this->country]);

        return $parts ? implode(', ', $parts) : 'Unknown';
    }

    public function toAdminArray(): array
    {
        return [
            'id' => $this->id,
            'visitor_uuid' => $this->visitor_uuid,
            'ip_address' => $this->ip_address,
            'country' => $this->country,
            'region' => $this->region,
            'city' => $this->city,
            'location' => $this->location_label,
            'email' => $this->email,
            'name' => $this->name,
            'browser' => $this->browser,
            'platform' => $this->platform,
            'device' => $this->device,
            'landing_page' => $this->landing_page,
            'referrer' => $this->referrer,
            'page_views_count' => $this->page_views_count,
            'events_count' => $this->events_count,
            'total_duration_seconds' => $this->total_duration_seconds,
            'first_seen_at' => $this->first_seen_at,
            'last_seen_at' => $this->last_seen_at,
        ];
    }
}
