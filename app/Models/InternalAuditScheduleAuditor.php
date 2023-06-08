<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalAuditScheduleAuditor extends Model
{
    use HasFactory, Uuids;

    protected $table = 'internal_audit_schedule_auditors';
    protected $primaryKey = 'id';
    protected $fillable = [
        'internal_audit_schedule_id', 'user_id',
    ];

    public function internal_audit_schedule()
    {
        return $this->belongsTo('App\Models\InternalAuditSchedule', 'internal_audit_schedule_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
