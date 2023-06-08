<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingDetailReview extends Model
{
    use HasFactory, Uuids;
    protected $table = 'meeting_detail_reviews';
    protected $primaryKey = 'id';
    protected $fillable = [
        'meeting_id', 'user_id', 'type', 'review_status', 'comment', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function meetings()
    {
        return $this->belongsTo('App\Models\Meeting', 'meeting_id', 'id');
    }
    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
