<?php

namespace App\Models;

use App\Enums\DepositMethod as EnumsDepositMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DepositMethod extends Model
{
    use HasFactory;

    // Mass Assignment
    protected $guarded = [];

    // Model attribute casting
    protected $cast = [
        'deposit_method' => EnumsDepositMethod::class,
    ];

    public function deposits() : HasMany {
        return $this->hasMany(Deposit::class, 'method_id');
    }
    
}
