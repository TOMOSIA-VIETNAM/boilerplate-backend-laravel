<?php

namespace App\Containers\User\Models;

use App\Core\Services\FileUploadService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department',
        'status',
        'avatar',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
        'avatar_url'
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \App\Containers\User\Models\UserFactory::new();
    }

    /**
     * Get the permissions for the user.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

    /**
     * Get the activities for the user.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get the blogs for the user.
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(\App\Containers\Blog\Models\Blog::class);
    }

    /**
     * Get the published blogs for the user.
     */
    public function publishedBlogs(): HasMany
    {
        return $this->hasMany(\App\Containers\Blog\Models\Blog::class)->published();
    }

    /**
     * Get the recent activities for the user.
     */
    public function recentActivities(): HasMany
    {
        return $this->hasMany(Activity::class)->recent();
    }

    /**
     * Get the login activities for the user.
     */
    public function loginActivities(): HasMany
    {
        return $this->hasMany(Activity::class)->withAction('login');
    }

    /**
     * Get avatar URL attribute
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if (!$this->avatar) {
            return null;
        }

        $fileUploadService = app(FileUploadService::class);
        return $fileUploadService->getUrl($this->avatar);
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        return $this->permissions()->whereIn('name', $permissions)->exists();
    }

    /**
     * Check if user has all of the given permissions
     */
    public function hasAllPermissions(array $permissions): bool
    {
        return $this->permissions()->whereIn('name', $permissions)->count() === count($permissions);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is manager
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Scope a query to only include active users
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include users with a specific role
     */
    public function scopeWithRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope a query to only include users in a specific department
     */
    public function scopeInDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    /**
     * Scope a query to only include users with avatar
     */
    public function scopeWithAvatar($query)
    {
        return $query->whereNotNull('avatar');
    }

    /**
     * Scope a query to only include users without avatar
     */
    public function scopeWithoutAvatar($query)
    {
        return $query->whereNull('avatar');
    }
} 