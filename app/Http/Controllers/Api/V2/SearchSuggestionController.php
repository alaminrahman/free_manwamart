<?php

namespace App\Http\Controllers\Api\V2;


use App\Search;
use App\Product;
use App\Brand;
use App\Shop;
use Illuminate\Http\Request;

class SearchSuggestionController extends Controller
{
    public function getList(Request $request)
    {
        $query_key = $request->query_key;
        $type = $request->type;

        $search_query  = Search::select('id', 'query', 'count');
        if ($query_key != "") {
            $search_query->where('query', 'like', "%{$query_key}%");
        }
        $searches = $search_query->orderBy('count', 'desc')->limit(10)->get();

        if ($type == "product") {
            $product_query = Product::query();
            if ($query_key != "") {
                $product_query->where(function ($query) use ($query_key) {
                    $query->where('name', 'like', "%{$query_key}%")->orWhere('tags', 'like', "%{$query_key}%");
                });
            }

            $products = filter_products($product_query)->limit(3)->get();
        }

        if ($type == "brands") {
            $brand_query = Brand::query();
            if ($query_key != "") {
                $brand_query->where('name', 'like', "%$query_key%");
            }

            $brands = $brand_query->limit(3)->get();
        }

        if ($type == "sellers") {
            $shop_query = Shop::query();
            if ($query_key != "") {
                $shop_query->where('name', 'like', "%$query_key%");
            }

            $shops = $shop_query->limit(3)->get();
        }



        $items = [];

        //shop push
        if ($type == "sellers" &&  !empty($shops)) {
            foreach ($shops as  $shop) {
                $item = [];
                $item['id'] = $shop->id;
                $item['query'] = $shop->name;
                $item['count'] = 0;
                $item['type'] = "shop";
                $item['type_string'] = "Shop";

                $items[] = $item;
            }
        }

        //brand push
        if ($type == "brands" && !empty($brands)) {
            foreach ($brands as  $brand) {
                $item = [];
                $item['id'] = $brand->id;
                $item['query'] = $brand->name;
                $item['count'] = 0;
                $item['type'] = "brand";
                $item['type_string'] = "Brand";

                $items[] = $item;
            }
        }
    
        //product push
        if ($type == "product" &&  !empty($products)) {
            foreach ($products as  $product) {
                $item = [];
                $item['id'] = $product->id;
                $item['query'] = $product->name;
                $item['count'] = 0;
                $item['type'] = "product";
                $item['type_string'] = "Product";

                $items[] = $item;
            }
        }

        //search push
        if (!empty($searches)) {
            foreach ($searches as  $search) {
                $item = [];
                $item['id'] = $search->id;
                $item['query'] = $search->query;
                $item['count'] = intval($search->count);
                $item['type'] = "search";
                $item['type_string'] = "Search";

                $items[] = $item;
            }
        }

        return $items; // should return a valid json of search list;
    }
}
