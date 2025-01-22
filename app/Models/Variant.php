<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Variant extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public $incrementing = false;

    // Initialisation des événements du modèle
    protected static function boot()
    {
        parent::boot();

        // Générer un UUID pour chaque nouvelle variante
        self::creating(function ($variant) {
            $variant->id = (string) Str::uuid();
        });
    }

    public function variantable()
    {
        return $this->morphTo();
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function availability()
    {
        return $this->belongsTo(Availability::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function document()
    {
        return $this->morphOne(Document::class, 'documentable');
    }
    public function wishlistItems()
    {
        return $this->morphMany(wishlist_item::class, 'wishlistable');
    }

    public function cartItems()
    {
        return $this->morphMany(cart_item::class, 'cartable');
    }

}
