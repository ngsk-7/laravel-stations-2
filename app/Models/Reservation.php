<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Schedule;
use App\Models\Sheet;

class Reservation extends Model
{
    use HasFactory;

    
    protected $fillable = ['date','schedule_id','sheet_id','email','name','is_canceled','created_at','updated_at'];

    public function schedules() {
        return $this->belongsTo(Schedule::class,'schedule_id','id');
    }

    public function sheets() {
        return $this->belongsTo(Sheet::class,'sheet_id','id');
    }
}
