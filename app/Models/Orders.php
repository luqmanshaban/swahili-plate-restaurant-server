<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'delivery_address',
        'contact',
        'payment_id',
    ];


    public function menu() {
        return $this->belongsToMany(Menu::class);
    }
    
}
