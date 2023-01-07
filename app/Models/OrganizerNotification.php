<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizerNotification extends Model
{
    use HasFactory;

    protected $table = "organizer_notifications";

    protected $fillable = ['message'];
}
