<?php

namespace App\Models;

use App\Enums\InterestPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    // Mass Assignment
    protected $guarded = [];

    // Model attribute casting
    protected $cast = [
        'interest_period' => InterestPeriod::class,
    ];

    public function investments() : HasMany {
        return $this->hasMany(Investment::class);
    }

    // Filter Plan Result Based on its Status
    public function scopeSortBy(Builder $query, $type): void
    {
        empty($type)
            ? $query
            : $query
            ->where('interest_period', $type);
    }

    // Filter Plan Result Based on its Search
    public function scopeSearch(Builder $query, $search): void
    {
        empty($search)
            ? $query
            : $query
            ->where('title', 'like', '%' . $search . '%')->orWhere('sub_title', 'like', '%' . $search . '%');
    }
    
}
