<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Referral extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function referral(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referral_id');
    }

    public function referee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referee_id');
    }

    public function transaction(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }



    // Filter Users Result Based on its Status
    public  function scopeSortBy(Builder $query, $type): void
    {
        $type == ''
            ? $query
            : $query
            ->where('status', $type);
    }

}
