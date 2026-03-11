<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRegister extends Model
{

    protected $table = 'student_registers';

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'address',
        'gender',
        'profile',
        'fname',
        'mname',
        'religion',
        'dob',
        'register_date',
        'year',
        'transport',
        'status',
        'tenant_id',
        'student_id',
    ];


    public function school()
    {
        return $this->belongsTo(School::class, 'tenant_id');
    }

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class, 'student_id');
    }

    public function examMarks()
    {
        return $this->hasMany(ExamMark::class, 'student_id');
    }

    public function admission()
    {
        return $this->hasOne(StudentAdmission::class, 'student_id');
    }
}
