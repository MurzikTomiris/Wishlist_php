<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCards extends Model
{
    protected $fillable = ['title', 'description', 'price', 'link', 'image', 'wishlist_id', 'IsReserved', 'IsActive'];  
    use HasFactory;

    public function wishlist(){
        return $this->belongsTo(Wishlists::class);
    }
}
