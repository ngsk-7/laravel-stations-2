<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sheet;
use App\Models\Schedule;
use App\Models\Reservation;

class Screen extends Model
{
    use HasFactory;
    public function sheet() {
        return $this->hasMany(Sheet::class);
    }
    public function schedule() {
        return $this->hasManyThrough(Schedule::class, Reservation::class);
    }
}
