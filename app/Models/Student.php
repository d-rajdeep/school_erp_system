<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'tenant_id',
        'admission_no',
        'name',
        'email',
        'phone',
        'class',
        'section',
        'admission_date'
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'tenant_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
