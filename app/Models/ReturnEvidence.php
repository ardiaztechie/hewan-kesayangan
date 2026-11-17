<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bukti foto/video pelanggan dan hasil pemeriksaan toko
 */
class ReturnEvidence extends Model
{
    protected $table = 'return_evidences';

    protected $fillable = [
        'return_request_id',
        'stage',
        'uploaded_by',
        'file_path',
        'file_type',
    ];

    protected function casts(): array
    {
        return [

        ];
    }

    public function returnRequest(): BelongsTo
    {
        return $this->belongsTo(ReturnRequest::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
