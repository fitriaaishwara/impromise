<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalAuditInstrument extends Model
{
    use HasFactory, Uuids;
    protected $table = 'internal_audit_instruments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'internal_audit_schedule_id', 'clause', 'question', 'observation', 'instrument_status', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function internal_audit_schedule()
    {
        return $this->belongsTo('App\Models\InternalAuditSchedule', 'internal_audit_schedule_id', 'id');
    }
}
