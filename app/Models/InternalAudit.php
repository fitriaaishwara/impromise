<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalAudit extends Model
{
    use HasFactory, Uuids;
    protected $table = 'internal_audits';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'start_date', 'end_date', 'location', 'note', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function internal_audit_auditors()
    {
        return $this->hasMany('App\Models\InternalAuditAuditor', 'internal_audit_id', 'id');
    }

    public function internal_audit_standards()
    {
        return $this->hasMany('App\Models\InternalAuditStandard', 'internal_audit_id', 'id');
    }

    

}
