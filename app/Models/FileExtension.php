<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileExtension extends Model
{
    use HasFactory, Uuids;
    protected $table = 'file_extensions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'extension', 'description'
    ];
}
