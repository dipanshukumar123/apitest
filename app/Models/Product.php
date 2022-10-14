<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    // protected $appends = ['image_url'];

    // public function getImageURLAttribute()
    // {
    //     return $this->attributes['image_url'] = $this->product_image ? url('/') . '/uploads/' . $this->product_image : null;
    // }

    protected $fillable = ['id','product_name','product_image','product_title','product_desc','product_token'];

    public $timestamps = true;
}
