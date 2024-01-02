<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;

class Genre extends Model
{
    use HasFactory;
    protected $fillable = ['name','created_at','updated_at'];

    public function movie() {
        return $this->hasMany(Movie::class);
    }
}
