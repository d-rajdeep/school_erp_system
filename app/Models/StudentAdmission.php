<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAdmission extends Model
{
    protected $table = 'student_admissions';

    // Protect against mass-assignment vulnerabilities
    protected $fillable = [
        'student_id',
        'class_id',
        'section_id',
        'year_id',
        'tenant_id',
        'admission_no',
        'admission_date',
        'roll_number',
        'fees_pay',
        'status',
    ];

    /**
     * Get the student associated with the admission.
     */
    public function student()
    {
        return $this->belongsTo(StudentRegister::class, 'student_id');
    }

    /**
     * Get the class associated with the admission.
     */
    public function schoolClass()
    {
        return $this->belongsTo(Classes::class, 'class_id'); // Assuming your model is named 'Classes'
    }

    /**
     * Get the section associated with the admission.
     */
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Get the academic year associated with the admission.
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'year_id');
    }
}
