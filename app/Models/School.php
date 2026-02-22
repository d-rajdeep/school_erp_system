<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'code',
        'email',
        'phone',
        'address',
        'logo',
        'status'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'tenant_id');
    }
}
