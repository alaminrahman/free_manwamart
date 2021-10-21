<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CourierAssignedProduct extends Model
{
    use HasFactory;

    protected $table = 'courier_assigned_products';

    protected $fillable = [
        'courier_assigned_id',
        'customer_id',
        'invoice_no',
        'cost',
        'item',
        'city_id',
        'zone_id',
        'area_id',
    ];

    public function customer()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }
}
