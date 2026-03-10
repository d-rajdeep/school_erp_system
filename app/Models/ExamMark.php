<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamMark extends Model
{
    protected $fillable = [
        'tenant_id',
        'exam_id',
        'class_id',
        'section_id',
        'subject_id',
        'student_id',
        'total_marks',
        'obtained_marks',
        'grade',
        'remarks'
    ];

    public function student()
    {
        return $this->belongsTo(StudentRegister::class, 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
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
