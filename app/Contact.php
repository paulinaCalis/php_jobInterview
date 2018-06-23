<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'profile_image',
        'favorite'
    ];

    public function phones() {
        return $this->hasMany('App\Phone');
    }
}
