<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'descriptions',
        'tags',
        'categories_id'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'products_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'categories_id', 'id');
    }
}
