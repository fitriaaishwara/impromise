<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalAuditAuditor extends Model
{
    use HasFactory, Uuids;
    protected $table = 'internal_audit_auditors';
    protected $primaryKey = 'id';
    protected $fillable = [
        'internal_audit_id', 'user_id', 'role'
    ];

    public function internal_audit()
    {
        return $this->belongsTo('App\Models\InternalAudit', 'internal_audit_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
