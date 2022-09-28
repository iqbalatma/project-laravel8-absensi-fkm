<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckinStatus extends Model
{
    use HasFactory;
    protected $fillable = ['checkin_status', 'user_id', 'congress_day_id', 'last_checkin_time', 'last_checkout_time'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function congressday()
    {
        return $this->belongsTo(CongressDay::class,'congress_day_id');
    }
}
