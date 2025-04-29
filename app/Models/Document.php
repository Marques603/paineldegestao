<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'file_path',
        'status',
        'macro_id',
        'revision',
        'user_id',
    ];

    public function macro()
    {
        return $this->belongsTo(Macro::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sectors()
    {
        return $this->belongsToMany(Sector::class, 'document_sector');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'document_company');
    }

    public function triages()
    {
        return $this->hasMany(DocumentTriage::class);
    }

    public function versions()
    {
        return $this->hasMany(DocumentVersion::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'document_user');
    }
}
