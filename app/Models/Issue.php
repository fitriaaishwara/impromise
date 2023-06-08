<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory, Uuids;
    protected $table = 'issues';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type', 'dimension', 'issue', 'created_by'
    ];
}
