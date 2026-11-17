<?php

namespace App\Models;

use App\Enums\ActorType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Timeline pengembalian yang dilihat pelanggan
 */
class ReturnStatusHistory extends Model
{
    protected $table = 'return_status_histories';

    public const UPDATED_AT = null;

    protected $fillable = [
        'return_request_id',
        'from_status',
        'to_status',
        'actor_type',
        'actor_id',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'actor_type' => ActorType::class,
            'created_at' => 'datetime',
        ];
    }

    public function returnRequest(): BelongsTo
    {
        return $this->belongsTo(ReturnRequest::class);
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
