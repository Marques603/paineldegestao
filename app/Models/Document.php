<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $table = 'document';

    protected $fillable = ['code', 'description', 'user_upload', 'revision', 'file_path', 'file_type', 'status'];

    // Relacionamento com Macro
    public function macros()
    {
        return $this->belongsToMany(Macro::class, 'document_macro');
    }

    // Relacionamento com Sector
    public function sectors()
    {
        return $this->belongsToMany(Sector::class, 'document_sector');
    }

    // Relacionamento com Approval
    public function approvals()
    {
        return $this->hasMany(DocumentApproval::class);
    }

    // Relacionamento com User (quem fez o upload)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_upload');
    }
}
