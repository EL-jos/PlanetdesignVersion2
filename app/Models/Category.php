<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'content'];

    public function subcategories(){
        return $this->hasMany(Subcategory::class);
    }

    public function document(){
        return $this->morphOne(Document::class, 'documentable');
    }

    public function getFirstImageAttribute(){
        return $this->document()->where('type','image')->first()->path;
    }
}
