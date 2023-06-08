<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingType extends Model
{
    use HasFactory, Uuids;
    protected $table = 'meeting_types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'description', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];
}
