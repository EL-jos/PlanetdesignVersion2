<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(cart_item::class);
    }

    public function createQuoteFromWishlist()
    {
        // Utiliser une transaction pour s'assurer que toutes les opérations se passent correctement
        return DB::transaction(function () {

            $user = $this->user;

            // Créer une nouvelle commande
            $quote = Quote::create([
                'user_id' => $user->id,
                'status_id' => 4
            ]);

            // Ajouter les items de la wishlist dans la commande
            foreach ($this->items as $wishlistItem) {
                $quote->items()->create([
                    'quoteable_id' => $wishlistItem->wishlistable_id,
                    'quoteable_type' => $wishlistItem->wishlistable_type,
                    'quantity' => $wishlistItem->quantity,
                ]);
            }

            // Vider la wishlist après création de la commande
            $this->items()->delete();

            // Retourner la commande créée
            return $quote;

        });
    }
}
