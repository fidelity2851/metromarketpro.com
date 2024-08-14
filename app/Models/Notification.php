<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Filter Notification Result Based on its Status
    public function scopeSortBy(Builder $query, $type): void
    {
        $type == 'read'
            ? $query->whereNotNull('read_at')
            : $query
            ->whereNull('read_at');
    }

     // Filter Notification Result Based on its Search
     public function scopeSearch(Builder $query, $search): void
     {
         empty($search)
             ? $query
             : $query
             ->where('text', 'like', '%' . $search . '%')->orWhere('type', 'like', '%' . $search . '%');
     }
}
