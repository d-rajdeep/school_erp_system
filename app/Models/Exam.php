<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['tenant_id', 'year_id', 'name', 'start_date', 'end_date', 'status'];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'year_id');
    }
}
