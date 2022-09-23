<?php

namespace App\Models;

use Database\Factories\CongressDayFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CongressDay extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['h_day', 'location'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CongressDayFactory::new();
    }
}
