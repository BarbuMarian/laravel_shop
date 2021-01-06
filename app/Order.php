<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name', 'phone', 'address',
    ];
    public $timestamps = false;

    public function products()
    {
      return $this->belongsToMany(Product::class)->withPivot(['product_amount']);
    }
}
