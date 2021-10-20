<tr class="product_row">
    <td>
        <input type="hidden" name="order_ids[]" value="{{$order->id}}">
        {{$order->invoice_no}}
    </td>
    <td>
        {{$order->name}}
    </td>
    <td>{{$order->address}}</td>
    <td>{{$order->mobile}}</td>
    <td>
    @if(env('EnableRedx') || env('PATHAO_ENABLE'))
        @if($courier_id == 1 && env('PATHAO_ENABLE'))
            <div>
                <input type="hidden" id="{{$row_index}}_city_value" value="{{$order->city_id}}">
                <div class="form-group">
                    {!! Form::select('city_id['.$order->id.']', $cities, '', ['class' => 'form-control select2','required'=>$courier_id == 1?1:0,'id'=>$row_index.'_city', 'placeholder'=>'Select city']); !!}
                </div>
            </div>
        @elseif($courier_id == 3 && env('EnableRedx'))
            <div>
                <div class="form-group">
                    {!! Form::select('redx_area_id['.$order->id.']', $redx_areas, '', ['class' => 'form-control select2','required','id'=>$row_index.'_city', 'placeholder'=>'Select city']); !!}
                </div>
            </div>
        @endif
    @endif
    </td>
    <td>
    @if(env('PATHAO_ENABLE'))

        @if($courier_id == 1)
            <div>
                <input type="hidden" id="{{$row_index}}_zone_value" value="{{$order->zone_id}}">
                <div class="form-group">
                    {!! Form::select('zone_id['.$order->id.']', [], '', ['class' => 'form-control select2 zone','id'=>$row_index.'_zone','required'=>$courier_id == 1?1:0,'placeholder'=>'Select city first']); !!}
                </div>
            </div>
        @endif
    @endif
    </td>
    <td class="text-right">
        <input type="hidden" class="amount_line_total" name="collection_amount[{{$order->id}}]" value="{{$order->final_total - $order->total_paid}}">
        {{number_format($order->final_total - $order->total_paid, 2)}}
    </td>
    <td class="text-right">
        <input type="hidden" class="product_line_total" value="{{$order->total_items}}">
        {{number_format($order->total_items)}}
    </td>
    <td class="text-center">
        <i class="fa fa-trash remove_product_row cursor-pointer" data-id="{{$order->id}}" aria-hidden="true"></i>
    </td>
</tr>