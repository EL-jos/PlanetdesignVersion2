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

    public function getImageAttribute(){
        return $this->document()->where('type', 'image')->first();
    }

    public function compressImage(int $w = 100, int $h = 100){

        $width = $w;
        $height = $h;

        // Obtenez le chemin complet de l'image
        $imagePath = public_path($this->image->path);

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

}
