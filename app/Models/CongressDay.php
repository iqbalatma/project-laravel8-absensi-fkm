<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CongressDay extends Model
{
    use HasFactory;

    protected $fillable = ['h_day', 'location'];
}
