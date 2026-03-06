<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    protected $fillable = [
        'tenant_id',
        'class_id',
        'section_id',
        'student_id',
        'attendance_date',
        'status',
        'remarks'
    ];

    public function student()
    {
        return $this->belongsTo(StudentRegister::class, 'student_id');
    }

    public function schoolClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
