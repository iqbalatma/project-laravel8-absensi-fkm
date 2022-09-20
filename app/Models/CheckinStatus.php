<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckinStatus extends Model
{
    use HasFactory;
    protected $fillable = ['checkin_status', 'user_id', 'congress_day_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
