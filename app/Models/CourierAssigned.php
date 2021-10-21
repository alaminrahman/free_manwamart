<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourierAssigned;
use App\Models\CourierAssignedProduct;
use App\User;

class CourierAssigned extends Model
{
    use HasFactory;

    protected $table = 'courier_assigneds';

    protected $fillable = [
        'create_by_id',
        'courier_id',
        'pay_ref_number',
        'total_item',
        'total_cost',
        'total_parcel',
        'additional_note',
        'date',
    ];

    public function courier_assigned_product()
    {
        return $this->hasMany(CourierAssignedProduct::class, 'courier_assigned_id','id');
    }

    public function create_by()
    {
        return $this->hasOne(User::class, 'id', 'create_by_id');
    }
}
