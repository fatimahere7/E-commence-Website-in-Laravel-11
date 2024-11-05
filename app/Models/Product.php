<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id','title','description','image','category','quantity','price'
    ];
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
     public function images()  // Notice it's plural to reference multiple images
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
}
