<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    //
    protected $fillable = [
        'number',
        'description',
        'contact_id'
    ];

    public function contact() {
        return $this->belongsTo('App\Contact');
    }
}
