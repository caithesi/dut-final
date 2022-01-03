<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $fillable = [
        'name',
        'price',
        'category_id',
        'user_id',
        'feature_img_path',
        'content',
        'feature_image_name'
    ];
    public function productImages($atts = '*')
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id')->select($atts);
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
