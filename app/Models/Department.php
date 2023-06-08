<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, Uuids;
    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'description', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function user_department()
    {
        return $this->hasMany('App\Models\Department', 'department_id', 'id');
    }
}
