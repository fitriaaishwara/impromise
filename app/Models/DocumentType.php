<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory, Uuids;
    protected $table = 'document_types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'file_extension_id', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function file_extension()
    {
        return $this->belongsTo('App\Models\FileExtension', 'file_extension_id', 'id');
    }
}
