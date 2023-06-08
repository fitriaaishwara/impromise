<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalAuditSchedule extends Model
{
    use HasFactory, Uuids;
    protected $table = 'internal_audit_schedules';
    protected $primaryKey = 'id';
    protected $fillable = [
        'internal_audit_id', 'department_id', 'date', 'start_time', 'end_time', 'process',
    ];

    public function internal_audit()
    {
        return $this->belongsTo('App\Models\InternalAudit', 'internal_audit_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }

    public function internal_audit_schedule_auditors()
    {
        return $this->hasMany('App\Models\InternalAuditScheduleAuditor', 'internal_audit_schedule_id', 'id');
    }

    public function internal_audit_instruments()
    {
        return $this->hasMany('App\Models\InternalAuditInstrument', 'internal_audit_schedule_id', 'id');
    }

    public function internal_audit_findings()
    {
        return $this->hasManyThrough('App\Models\InternalAuditFinding', 'App\Models\InternalAuditInstrument', 'internal_audit_schedule_id', 'id');
    }
}
