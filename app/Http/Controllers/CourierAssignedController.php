<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourierAssigned;
use App\Models\CourierAssignedProduct;
use App\Models\Order;
use App\Utility\NotificationUtility;

class CourierAssignedController extends Controller
{
    public function courier_assined_store(Request $request)
    {
      CourierAssigned::create([
            'create_by_id' => $request->created_by,
            'courier_id' => $request->courier,
            'pay_ref_number' => 'fdf',
            'total_item' => $request->total_item,
            'total_cost' => $request->total_cost,
            'total_parcel' => $request->total_parcel,
            'additional_note' => $request->additional_note,
            'date' => $request->date,
        ]);

        $courier_assigned = CourierAssigned::latest()->first();

        $courier_assigned_product = new CourierAssignedProduct;
        $courier_assigned_id = $courier_assigned->id;
        $invoice_no = $request->order_code;
        $customer_id = $request->customer_id;
        $cost = $request->single_price;
        $item = $request->item;
        $city_id = $request->city;
        $zone_id = $request->zone;
        $area_id = $request->area;

        for($i = 0; $i <= $request->total_item-1; $i++){
            $data = [
                'courier_assigned_id' => $courier_assigned_id,
                'invoice_no' => $invoice_no[$i],
                'customer_id' => $customer_id[$i],
                'cost' => $cost[$i],
                'item' => $item[$i],
                'city_id' => $city_id[$i],
                'zone_id' => $zone_id[$i],
                'area_id' => $area_id[$i],
            ];
            CourierAssignedProduct::insert($data);

        }
        Order::whereIn('code', $request->order_code)->update(['is_courier_assigned' => 1]);

        flash(translate('Assign successfull!'))->success();
        return redirect()->route('courier.assignment_index');

    }


    //End
}
