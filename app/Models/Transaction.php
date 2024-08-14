<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function transactionable(): MorphTo {
        return $this->morphTo();
    }



    // Filter Transactions Result Based on its Status
    public  function scopeSortBy(Builder $query, $type): void
    {
        $type == ''
            ? $query
            : $query
            ->where('status', $type);
    }
}
