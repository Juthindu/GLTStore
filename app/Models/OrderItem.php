<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'inventory_id',
        'quantity',
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
    
}