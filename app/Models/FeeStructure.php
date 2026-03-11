<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    protected $fillable = ['tenant_id', 'year_id', 'class_id', 'fee_type_id', 'amount'];

    public function schoolClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class, 'fee_type_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'year_id');
    }
}
