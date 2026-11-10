<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    /**
     * Nama tabel.
     */
    protected $table = 'activity_logs';


    /**
     * Kolom yang boleh diisi menggunakan create().
     */
    protected $fillable = [
        'user_id',
        'action',
    ];


    /**
     * Relasi ke User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}