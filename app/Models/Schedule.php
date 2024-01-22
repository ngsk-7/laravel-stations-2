<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;
use App\Models\Reservation;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id','start_time','end_time','created_at','updated_at'];

    public function movie() {
        return $this->belongsTo(Movie::class,'movie_id','id');
    }
    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    protected $dates = [
        'start_time','end_time'
    ];
}
