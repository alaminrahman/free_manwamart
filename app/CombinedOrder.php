<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CombinedOrder extends Model
{
    public function orders(){
    	return $this->hasMany(Order::class);
    }
}
