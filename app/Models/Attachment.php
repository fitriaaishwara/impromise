<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory, Uuids;
    protected $table = 'attachments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'path', 'name', 'extension', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];
    public function document()
    {
        return $this->hasOne('App\Models\Document', 'attachment_id', 'id');
    }
}
