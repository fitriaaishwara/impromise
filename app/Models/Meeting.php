<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory, Uuids;
    protected $table = 'meetings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'meeting_type_id', 'participant', 'agenda', 'date', 'start_time', 'end_time', 'location', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function meeting_type()
    {
        return $this->belongsTo('App\Models\MeetingType', 'meeting_type_id', 'id');
    }
    public function meeting_participants()
    {
        return $this->hasMany('App\Models\MeetingParticipant', 'meeting_id', 'id');
    }
    public function meeting_details()
    {
        return $this->hasMany('App\Models\MeetingDetail', 'meeting_id', 'id');
    }
    public function meeting_attendees()
    {
        return $this->hasMany('App\Models\MeetingAttendee', 'meeting_id', 'id');
    }
}
