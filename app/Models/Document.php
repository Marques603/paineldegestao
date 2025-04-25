<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'user_upload_id',
        'revision',
        'macro_id',
        'file_path',
        'file_type',
        'status',
    ];

    public function macro()
    {
        return $this->belongsTo(Macro::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'user_upload_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function sectors()
    {
        return $this->belongsToMany(Sector::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }
}
