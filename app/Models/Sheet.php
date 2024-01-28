<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;
use App\Models\Screen;

class Sheet extends Model
{
    use HasFactory;
    public function reservations() {
        return $this->hasMany(Reservation::class,'sheet_id','id');
    }
    public function screen() {
        return $this->belongsTo(Screen::class);
    }
}
