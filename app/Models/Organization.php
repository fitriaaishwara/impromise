<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory, Uuids;
    protected $table = 'organizations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'address', 'structure', 'business_process', 'created_by',
    ];

    public function organizationStandard()
    {
        return $this->hasMany(OrganizationStandard::class, 'organization_id', 'id');
    }
}
