<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = ['uuid', 'name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
