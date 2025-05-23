<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function support_ticket(): BelongsTo
    {
        return $this->belongsTo(SupportTicket::class,);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
