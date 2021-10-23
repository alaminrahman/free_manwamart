<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AddsellController extends Controller
{
    public function addsell_index(){
        return view('backend.sales.add_sell.create');
     }//End function

     public function get_product(Request $request)
     {
         dd($request->keyword);

         $product = Order::where('code', 'LIKE', $request->keyword.'%')
                    ->orderby('id','desc')
                    ->get();

            $output = '';

            if (count($product)>0) {
                $output = '<ul class="list-group" id="result" style="display: block; position: relative; z-index: 1;">';
                foreach ($product as $row){
                    if($row->is_courier_assigned ==1){
                        $msg = "Already Assigned";
                    }else{
                        $msg = "New";
                    }

                    $output .= '<li class="list-group-item"  onclick="getOrder('.$row->code.')" >'.$row->code.'('.$msg.')</li>';
                }
                $output .= '</ul>';
            }
            else {
                $output .= '<li class="list-group-item">'.'No results'.'</li>';
            }
            return $output;
     }


     public function addsell_store(Request $request)
     {
         dd($request->all());
     }
     //End
}
