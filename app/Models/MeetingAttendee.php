<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingAttendee extends Model
{
    use HasFactory, Uuids;
    protected $table = 'meeting_attendees';
    protected $primaryKey = 'id';
    protected $fillable = [
        'meeting_id', 'name', 'role'
    ];
}
