<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingParticipant extends Model
{
    use HasFactory, Uuids;
    protected $table = 'meeting_participants';
    protected $primaryKey = 'id';
    protected $fillable = [
        'meeting_id', 'department_id', 'user_id'
    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
