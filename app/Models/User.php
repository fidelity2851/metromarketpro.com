<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function tickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function referee(): HasMany
    {
        return $this->hasMany(Referral::class, 'referral_id');
    }
    
    public function referral(): HasOne
    {
        return $this->hasOne(Referral::class, 'referee_id');
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Management::class, 'manager_id');
    }

    public function manager(): HasOne
    {
        return $this->hasOne(Management::class, 'client_id');
    }

    public function kyc(): HasOne
    {
        return $this->hasOne(KYC::class);
    }

    public function transations(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function deposit(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawal(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }
    public function withdrawal_method(): HasOne
    {
        return $this->hasOne(WithdrawalMethod::class);
    }

    public function investment(): HasMany
    {
        return $this->hasMany(Investment::class);
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
            ->where('username', 'like', '%' . $search . '%')->orWhere('fullname', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
    }

    // protected function google2faSecret() : Attribute {
    //     return Attribute::make(
    //         get: fn ($value) => decrypt($value),
    //         set: fn ($value) => encrypt($value),
    //     );
    // }
}
