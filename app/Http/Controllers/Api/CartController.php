<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CartCollection;
use App\Models\Cart;
use App\Models\Color;
use App\Models\FlashDeal;
use App\Models\FlashDealProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index($id)
    {
        return new CartCollection(Cart::where('user_id', $id)->latest()->get());
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $variant = $request->variant;
        $color = $request->color;
        $tax = 0;

        if ($variant == '' && $color == '')
            $price = $product->unit_price;
        else {
            $product_stock = $product->stocks->where('variant', $variant)->first();
            $price = $product_stock->price;
        }

        //discount calculation
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        }
        elseif (strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }

        //calculation of taxes
        if ($product->tax_type == 'percent') {
            $tax = ($price * $product->tax) / 100;
        }
        elseif ($product->tax_type == 'amount') {
            $tax = $product->tax;
        }

        Cart::updateOrCreate([
            'user_id' => $request->user_id,
            'product_id' => $request->id,
            'variation' => $variant
        ], [
            'price' => $price,
            'tax' => $tax,
            'shipping_cost' => 0,
            'quantity' => DB::raw('quantity + 1')
        ]);

        return response()->json([
            'message' => 'Product added to cart successfully'
        ]);
    }

    public function changeQuantity(Request $request)
    {
        $cart = Cart::find($request->id);
        if ($cart != null) {
            if ($cart->product->stocks->where('variant', $cart->variation)->first()->qty >= $request->quantity) {
                $cart->update([
                    'quantity' => $request->quantity
                ]);

                return response()->json(['message' => 'Cart updated'], 200);
            }
            else {
                return response()->json(['message' => 'Maximum available quantity reached'], 200);
            }
        }

        return response()->json(['message' => 'Something went wrong'], 200);
    }

    public function destroy($id)
    {
        Cart::destroy($id);
        return response()->json(['message' => 'Product is successfully removed from your cart'], 200);
    }
}
