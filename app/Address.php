<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['set_default'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
