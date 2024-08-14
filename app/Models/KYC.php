<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\KycStatus;
use Illuminate\Database\Eloquent\Builder;

class KYC extends Model
{
    use HasFactory;

    // Provide Database Name
    protected $table = 'kyc';

    // Mass Assignment
    protected $guarded = [];

    // Model attribute casting
    protected $cast = [
        'status' => KycStatus::class,
    ];

    // Define User Relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Filter Kyc Result Based on its Status
    public  function scopeSortBy(Builder $query, $type): void
    {
        empty($type)
            ? $query
            : $query
            ->where('status', $type);
    }
}
