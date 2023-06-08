<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table = 'documents';
    protected $primaryKey = 'id';
    protected $fillable = [
        'folder_id', 'attachment_id', 'name', 'no_document', 'date', 'revisi', 'description', 'extension', 'size', 'download', 'status', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'
    ];

    public function folder()
    {
        return $this->belongsTo('App\Models\Folder', 'folder_id', 'id');
    }
    public function attachment()
    {
        return $this->belongsTo('App\Models\Attachment', 'attachment_id', 'id');
    }
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function deletedBy()
    {
        return $this->belongsTo('App\Models\User', 'deleted_by', 'id');
    }
}
