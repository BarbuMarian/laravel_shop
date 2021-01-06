<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'pic'
    ];
    public $timestamps = false;

    public function orders()
    {
       return $this->belongsToMany(Order::class)->withPivot(['product_amount']);
    }


}
