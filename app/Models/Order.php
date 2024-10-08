<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'user_id', 'name', 'email', 'address', 'note' , 'sale', 'status', 'phone', 'total_price', 'payment', 'created_at', 'updated_at'





    ];
    public function products():BelongsToMany
    {
        return $this->belongsToMany(Product::class,'order__products')->withPivot('quantity');
    }
}
