<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingDetail extends Model
{
    use HasFactory, Uuids;
    protected $table = 'meeting_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'meeting_id', 'temporary_id', 'department_id', 'user_id', 'pic', 'discussion', 'last_status', 'due_date', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function meetings()
    {
        return $this->belongsTo('App\Models\Meeting', 'meeting_id', 'id');
    }
    public function departments()
    {
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }
    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
