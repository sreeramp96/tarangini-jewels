<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'pincode',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
