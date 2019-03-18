<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'address',
        'vendor_id',
    ];  

    //db relationship
    //product_id field belongs to id in Product table
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    //user that buys that product 'user_id',
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    //vendor that sells this product
    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }


}
