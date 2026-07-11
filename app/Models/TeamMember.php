<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'role',
        'image',
        'short_bio',
        'bio',
        'focus',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'focus' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getImageUrlAttribute(): string
    {
        $image = (string) ($this->image ?? '');

        if ($image === '') {
            return '/onix/assets/images/LOGO10.png';
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://') || str_starts_with($image, '/')) {
            return $image;
        }

        return '/onix/assets/images/'.$image;
    }

    public function toPublicArray(): array
    {
        return [
            'id' => $this->slug,
            'name' => $this->name,
            'role' => $this->role,
            'image' => $this->image,
            'image_url' => $this->image_url,
            'shortBio' => $this->short_bio,
            'bio' => $this->bio,
            'focus' => $this->focus ?? [],
        ];
    }

    public function toAdminArray(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'role' => $this->role,
            'image' => $this->image,
            'image_url' => $this->image_url,
            'short_bio' => $this->short_bio,
            'bio' => $this->bio,
            'focus' => $this->focus ?? [],
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
