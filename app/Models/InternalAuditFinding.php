<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalAuditFinding extends Model
{
    use HasFactory, Uuids;

    protected $table = 'internal_audit_findings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'internal_audit_instrument_id', 'analysis', 'correction', 'corrective', 'review', 'suitable',
    ];

    public function internal_audit_instrument()
    {
        return $this->belongsTo('App\Models\InternalAuditInstrument', 'internal_audit_instrument_id', 'id');
    }
}
