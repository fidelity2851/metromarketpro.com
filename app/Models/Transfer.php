<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Transfer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

     // Filter Transfer Result Based on its Status
     public  function scopeSortBy(Builder $query, $type): void
     {
         $type == ''
             ? $query
             : $query
             ->where('status', $type);
     }
 
     // Filter Transfer Result Based on its Search
     public function scopeSearch(Builder $query, $search): void
     {
         empty($search)
             ? $query
             : $query
             ->where('trx_num', 'like', '%' . $search . '%')->orWhere('amount', 'like', '%' . $search . '%');
     }
}
