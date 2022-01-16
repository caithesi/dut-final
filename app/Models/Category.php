<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'parent_id',
        'slug'
    ];
    public function categoriesChildren()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categoriesChildren');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
