<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public static function booted()
    {
        // Tri par défaut selon la colonne "priority" en ordre croissant
        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('priority', 'asc');
        });
    }

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }
}
