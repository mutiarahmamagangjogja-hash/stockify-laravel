<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'description',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }


    public static function log(
        string $action,
        ?string $description = null
    ): self {

        return self::create([

            'user_id' =>
                auth()->id(),

            'action' =>
                $action,

            'description' =>
                $description,

        ]);
    }
}