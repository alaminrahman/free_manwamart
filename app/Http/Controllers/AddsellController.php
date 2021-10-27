<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Cart;
use Session;
use Auth;
use App\Http\Controllers;

class AddsellController extends Controller
{
    public function addsell_index(){
        return view('backend.sales.add_sell.create');
     }//End function

     public function get_product_search(Request $request)
     {
         $product = Product::where('name', 'LIKE', $request->keyword.'%')
                    ->orderby('id','desc')
                    ->get();

            $output = '';
            if (count($product)>0) {
                $output = '<ul class="list-group">';
                foreach ($product as $row){
                    $output .= '<li class="list-group-item"  onclick="addProductCart('.$row->id.')" >';
                    $output .= '<div class="product d-flex align-items-center">';

                    $output .= '<div class="img mr-2">';
                    $output .= '<img src="'.uploaded_asset($row->thumbnail_img).'" width="30" alt="Product Image">';
                    $output .= '</div>';

                    $output .= ' <div class="pro-nam">'.$row->name.'</div></div></li></ul>';

                }
            }else{
                $output = '<ul class="list-group">';
                $output .= '<li class="list-group-item">'.'No results'.'</li>';
                $output .= '</ul>';
            }

            return $output;
     }

     public function get_product(Request $request)
     {

         $product = Product::where('id', $request->product_id)->first();

         $carts = array();
         $data = array();
         $data['product_id'] = $request->product_id;
         $data['owner_id'] = Auth::user()->id;
         $data['quantity'] = 1;
         $data['price'] = $product->unit_price;
         $data['sell_type'] = "sell_by_admin";
         //Start Cart

         Session::put('sell_type', 'sell_by_admin');
         $request = new \Illuminate\Http\Request();
        //  $request->replace($data);

         $cartController = new CartController;
         $cartController->addToCart($request->replace($data));

        // $cart = Cart::create($data);
            // Cart::destroy($request->product_id);
         //End Cart

         $html = '';
         $html .= '<tr>';
         $html .= '<th scope="row" class="text-center" >'.$product->id;
         $html .='<input type="hidden" name="product_id[]" id="product_id_'.$request->product_id.'" value="'.$product->id.'">';
         $html .='</th>';
         $html .= '<td>'.$product->name.'</td>';
         $html .= '<td class="text-center">';
         $html .='<span id="qty_show_'.$request->product_id.'">1</span>';
         $html .='<input type="hidden" name="product_qty[]" id="qty_'.$request->product_id.'" value="1">';
         $html .='</td>';
         $html .= '<td class="text-center">';
         $html .='<span id="price_show_'.$request->product_id.'">'.$product->unit_price.'</span>';
         $html .='<input type="hidden" name="product_price[]" id="price_'.$request->product_id.'" value="'.$product->unit_price.'" class="price">';
         $html .='</td>';
         $html .= '<td class="text-center">';
         $html .= '<button class="btn btn-danger" onclick="removeItem()">Remove</button>';
         $html .= '</td>';
         $html .= '</tr>';

         return $html;

     }


     public function addsell_store(Request $request)
     {
        $checkoutController = new CheckoutController;

        $data = [];
        $data['payment_option'] = $request->payment_option;
        $data['payment_status'] = $request->payment_status;

        $request = new \Illuminate\Http\Request();
        $checkoutController->checkout($request->replace($data));

        return redirect()->route('all_orders.index');
     }

     public function clear_cart_item()
     {
        Cart::where('user_id', Auth::user()->id)
                ->delete();
        flash(translate("Clear Cart successfully"))->success();
        return redirect()->back();
     }
     //End
}
