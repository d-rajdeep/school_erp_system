<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    protected $fillable = [
        'tenant_id',
        'year_id',
        'student_id',
        'class_id',
        'fee_type_id',
        'paid_amount',
        'payment_date',
        'payment_method',
        'receipt_number',
        'remarks'
    ];

    public function student()
    {
        return $this->belongsTo(StudentRegister::class, 'student_id');
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class, 'fee_type_id');
    }

    public function schoolClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
