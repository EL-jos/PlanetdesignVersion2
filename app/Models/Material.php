<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['name'];

    public function articles(){
        return $this->belongsToMany(Article::class);
    }
}
