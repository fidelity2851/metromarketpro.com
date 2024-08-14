<?php

namespace App\Models;

use App\Enums\RoleTitle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $cast = [
        'title' => RoleTitle::class,
    ];

    public function users() : HasMany {
        return $this->hasMany(User::class);
    }
}
