<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Deposit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deposit_method(): BelongsTo
    {
        return $this->belongsTo(DepositMethod::class, 'method_id');
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    // Filter Deposit Result Based on its Status
    public function scopeSortBy(Builder $query, $type): void
    {
        $type == ''
            ? $query
            : $query
            ->where('status', $type);
    }

    // Filter Deposit Result Based on its Search
    public function scopeSearch(Builder $query, $search): void
    {
        empty($search)
            ? $query
            : $query
            ->where('trx_num', 'like', '%' . $search . '%')->orWhere('amount', 'like', '%' . $search . '%');
    }
}
