<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name','price','detail','image'
    ];

    public function product_images(){
        return $this->hasMany('App\ProductImage');
    }
}
