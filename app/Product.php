<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'units',
        'description',
        'category',
        'image',
        'vendor_id',
    ];

    //db relationship with orders
    // each producst can has many orders

    public function orders(){
        return $this->hasMany(Order::class);
    }

    //each products belongsTo a Vendor
    public function vendor(){
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
}
