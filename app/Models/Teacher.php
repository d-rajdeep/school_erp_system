<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'employee_register_id',
        'fullname',
        'email',
        'mobile',
        'password',
        'address',
        'gender',
        'profile',
        'father_name',
        'mother_name',
        'religion',
        'dob',
        'joining_date',
        'salary',
        'register_date',
        'status',
        'bank_name',
        'account_number',
        'ifsc_code',
    ];

    // Hide the password when retrieving data for security
    protected $hidden = [
        'password',
    ];

    // Optional: If you have a Tenant model, define the relationship
    public function tenant()
    {
        return $this->belongsTo(School::class); // Or School::class, depending on your setup
    }
}
