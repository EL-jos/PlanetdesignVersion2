<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public $incrementing = false;

    // Initialisation des événements du modèle
    protected static function boot()
    {
        parent::boot();

        // Générer un UUID pour chaque nouvel article
        self::creating(function ($article) {
            $article->id = (string) Str::uuid();
        });
    }

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }

    public function wishlistItems()
    {
        return $this->morphMany(WishlistItem::class, 'wishlistable');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function availability()
    {
        return $this->belongsTo(Availability::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function getImagesAttribute(){
        return $this->documents()->where('type', 'image')->get();
    }
    public function getFirstImageAttribute()
    {
        return $this->documents()->where('type', 'image')->first()->path;
    }

    public function getLastImageAttribute()
    {
        return $this->documents()->where('type', 'image')->get()->last()->path;
    }

}
