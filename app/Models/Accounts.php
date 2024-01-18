<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    protected $fillable = ['login', 'password', 'name', 'email'];  
    use HasFactory;

    public function wishlists(){
        return $this->hasMany(Wishlists::class, "AccountId", "id");
    }
}
