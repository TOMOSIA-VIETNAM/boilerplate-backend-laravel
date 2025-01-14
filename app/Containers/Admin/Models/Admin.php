<?php

namespace App\Containers\Admin\Models;

use App\Containers\Admin\Models\Traits\Methods\AdminMethod;
use App\Containers\Admin\Models\Traits\Attributes\AdminAttribute;
use App\Containers\Admin\Models\Traits\Relationships\AdminRelationship;
use App\Enums\LogNameEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Admin extends Authenticatable
{
    use HasFactory;
    use AdminMethod;
    use AdminAttribute;
    use AdminRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    protected static $logAttributes = ['email'];

    protected static $logName = LogNameEnum::ADMIN;

    protected static $logOnlyDirty = true;

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(self::$logAttributes)
            ->logOnlyDirty()
            ->useLogName(self::$logName);
    }

    /**
     * Update description column
     *
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.email has been {$eventName}";
    }
}
