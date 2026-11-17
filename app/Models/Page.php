<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Halaman profil brand dan informasi (cara belanja, kebijakan)
 */
class Page extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'content',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
