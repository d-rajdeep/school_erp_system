<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'tenant_id',
        'user_id',
        'module',
        'action',
        'description',
        'ip_address'
    ];

    // Link back to the user who did the action
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
