<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Investment extends Model
{
    use HasFactory;

    // Mass Assignment
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function transaction(): MorphMany    {
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

    // Filter Users Result Based on its Search
    public  function scopeSearch(Builder $query, $search): void
    {
        empty($search)
            ? $query
            : $query
            ->where('trx_num', 'like', '%' . $search . '%')->orWhere('amount', 'like', '%' . $search . '%')->orWhere('due_date', 'like', '%' . $search . '%');
    }
}
