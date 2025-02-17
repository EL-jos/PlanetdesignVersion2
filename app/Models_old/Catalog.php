<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function colors(){
        return $this->belongsToMany(Color::class);
    }

    public function sizes(){
        return $this->belongsToMany(Size::class);
    }
}
