<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Uuids, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'photo',
        'is_active',
        'login_failed_count',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_department()
    {
        return $this->hasMany('App\Models\UserDepartment', 'user_id', 'id');
    }

    public function user_position()
    {
        return $this->hasMany('App\Models\UserPosition', 'user_id', 'id');
    }

    public function user_role()
    {
        return $this->hasMany('App\Models\UserRole', 'user_id', 'id');
    }

    public function internal_audit_auditors()
    {
        return $this->hasMany('App\Models\InternalAuditAuditor', 'user_id', 'id');
    }

    public function internal_audit_schedule_auditors()
    {
        return $this->hasMany('App\Models\InternalAuditScheduleAuditor', 'user_id', 'id');
    }


}
