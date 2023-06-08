<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    use HasFactory, Uuids;
    protected $table = 'user_departments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'department_id', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }
}
