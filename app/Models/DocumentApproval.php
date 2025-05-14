<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentApproval extends Model
{
    protected $table = 'document_approvals';

    protected $fillable = [
        'document_id',
        'user_id',
        'approved_at',
    ];

    public $timestamps = true;

    // Relacionamento com documento
    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    // Relacionamento com usuário (quem aprovou)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
