<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    use HasFactory, Uuids;
    protected $table = 'standards';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'description', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function internal_audit_standards()
    {
        return $this->hasMany('App\Models\InternalAuditStandard', 'standard_id', 'id');
    }

    public function organization_standards()
    {
        return $this->hasMany('App\Models\OrganizationStandard', 'standard_id', 'id');
    }
}
