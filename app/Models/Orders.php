<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'img',
        'quantity',
        'total',
        'status',
        'delivery_address',
        'contact',
        'payment_id',
    ];


    public function menu() {
        return $this->belongsToMany(Menu::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    
}
