<?php

namespace App\Models;

use App\Models\Orders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'img',
        'price',
        'category',
    ];

    
    public function orders() {
        return $this->belongsToMany(Orders::class);
    }

}
