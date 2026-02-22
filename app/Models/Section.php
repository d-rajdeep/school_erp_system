<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'tenant_id',
        'class_id',
        'name'
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
