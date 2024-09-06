<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeaType extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'grade',
    ];
    
    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }
    
}
