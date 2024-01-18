<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlists extends Model
{
    protected $fillable = ['name', 'description', 'listLink', 'AccountId', 'IsActive'];  
    use HasFactory;

    public function account(){
        return $this->belongsTo(Accounts::class);
    }

    public function giftCards(){
        return $this->hasMany(GiftCards::class, "wishlist_id", "id");
    }
}
