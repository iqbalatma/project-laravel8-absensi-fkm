<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationCredential extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['token', 'is_active', 'role_id', 'organization_id', 'limit' ];


    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
