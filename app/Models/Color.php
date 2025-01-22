<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function document(){
        return $this->morphOne(Document::class, 'documentable');
    }

    public function variants(){
        return $this->hasMany(Variant::class);
    }
}
