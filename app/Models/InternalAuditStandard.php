<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\CssSelector\Node\FunctionNode;

class InternalAuditStandard extends Model
{
    use HasFactory, Uuids;
    protected $table = 'internal_audits_standards';
    protected $primaryKey = 'id';
    protected $fillable = [
        'internal_audit_id', 'standard_id'
    ];

    public function internal_audit()
    {
        return $this->belongsTo('App\Models\InternalAudit', 'internal_audit_id', 'id');
    }

    public function standard()
    {
        return $this->belongsTo('App\Models\Standard', 'standard_id', 'id');
    }
}
