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
        'status',
        'school_admin_id',
    ];

    public function admin()
    {
        return $this->hasOne(User::class, 'tenant_id', 'id');
    }

    // All users (staff) belonging to this school
    public function users()
    {
        return $this->hasMany(User::class, 'tenant_id');
    }

    // Students registered under this school
    public function students()
    {
        return $this->hasMany(\App\Models\StudentRegister::class, 'tenant_id');
    }

    // Teachers belonging to this school
    public function teachers()
    {
        return $this->hasMany(\App\Models\Teacher::class, 'tenant_id');
    }

    // Classes belonging to this school
    public function classes()
    {
        return $this->hasMany(\App\Models\Classes::class, 'tenant_id');
    }
}
