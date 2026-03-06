<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'address',
        'city',
        'zip',
        'country',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
