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

        // Tri par défaut selon la colonne "priority" en ordre croissant
        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('priority', 'asc');
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

    public function compressImage(int $w = 100, int $h = 100){

        $width = $w;
        $height = $h;

        // Obtenez le chemin complet de l'image
        $imagePath = public_path($this->first_image);

        // Vérifier si le fichier existe
        if (file_exists($imagePath)) {
            // Redimensionner l'image
            $image = \Intervention\Image\Facades\Image::make($imagePath);

            // Redimensionner l'image si les paramètres de taille sont spécifiés
            if ($width && $height) {
                $image->fit($width, $height);
            }

            // Obtenez l'encodage de l'image redimensionnée
            $encodedImage = $image->encode('data-url');

            // Afficher l'image redimensionnée dans la balise <img>
            //return $encodedImage;
            //echo '<img src="'.$encodedImage.'">';
            echo $encodedImage;
        }else{
            dd('Le fichier n\existe pas');
        }

    }

    public function getVariantIsColorAttribute(): bool{
        //dd($this->variants->first()->color === null);
        return $this->variants->first()->color !== null;
    }

    public function getVariantIsSizeAttribute(): bool{
        //dd($this->variants->first()->size === null);
        return $this->variants->first()->size !== null;
    }

}
