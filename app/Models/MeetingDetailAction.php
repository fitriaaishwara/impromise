<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingDetailAction extends Model
{
    use HasFactory, Uuids;
    protected $table = 'meeting_detail_actions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'meeting_id', 'action_status', 'defer_date', 'comment', 'attachment', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function meeting()
    {
        return $this->belongsTo('App\Models\Meeting', 'meeting_id', 'id');
    }
}
