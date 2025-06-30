<?php

namespace App\Containers\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'description',
        'guard_name',
    ];

    /**
     * Get the users that have this permission.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_permissions');
    }

    /**
     * Scope a query to only include permissions for a specific guard.
     */
    public function scopeForGuard($query, $guard)
    {
        return $query->where('guard_name', $guard);
    }

    /**
     * Scope a query to only include permissions with a specific name pattern.
     */
    public function scopeWithName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }
} 