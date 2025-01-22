<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function document()
    {
        return $this->morphOne(Document::class, 'documentable');
    }

    public function articles(){
        return $this->belongsToMany(Article::class);
    }
}
