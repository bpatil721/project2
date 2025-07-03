<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title','sku','qty','category'];

    public function category(){
        return $this->hasOne(\App\Models\Category::class,'id','category');
    }
    
}
