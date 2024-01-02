<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;

class Movie extends Model
{
    use HasFactory;
    
    protected $fillable = ['title','image_url','published_year','is_showing','description','created_at','updated_at'];

    public function genre() {
        return $this->belongsTo(Genre::class);
    }
}
