<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id','start_time','end_time','created_at','updated_at'];

    public function movies() {
        return $this->belongsTo(Movie::class,'movie_id','id');
    }

    protected $dates = [
        'start_time','end_time'
    ];
}
