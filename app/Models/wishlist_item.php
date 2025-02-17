<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class wishlist_item extends Model
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

    public function wishlistable()
    {
        return $this->morphTo();
    }

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }
}
