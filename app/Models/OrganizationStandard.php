<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationStandard extends Model
{
    use HasFactory, Uuids;
    protected $table = 'organization_standards';
    protected $primaryKey = 'id';
    protected $fillable = [
        'organization_id', 'standard_id', 'scope', 'created_by',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function standard()
    {
        return $this->belongsTo(Standard::class, 'standard_id', 'id');
    }
}
