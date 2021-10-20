<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <div class="table-responsive">
            <table class="table table-condensed bg-gray">
                <tr>
                    <th>@lang('sale.invoice_no')</th>
                    <th>@lang('contact.customer')</th>
                    <th>@lang('business.address')</th>
                    <th>@lang('contact.mobile')</th>
                    <th>@lang('sale.amount')</th>
{{--                    <th class="text-center">--}}
{{--                        @lang('custom.payment_type')--}}
{{--                    </th>--}}
{{--                    <th>@lang('purchase.payment_status')</th>--}}
                    <th>Total items</th>
					<th>Total items 2</th>
                </tr>
                @foreach( $list as $o )
                    <tr>
                        <td>
                            {{$o->invoice_no}}
                        </td>
                        <td>{{$o->name}}</td>
                        <td>{{$o->address}}</td>
                        <td>{{$o->mobile}}</td>
                        <td>{{$as->collection_amount[$o->id]}}</td>
{{--                        <td class="text-center">{{$o->payment_type?__('custom.'.$o->payment_type): $o->wp_payment_data}}</td>--}}
{{--                        <td>@if($o->courier_payment_status)<span class="label {{$o->courier_payment_status == 'Paid'?'bg-green':'bg-red'}}">{{$o->courier_payment_status}}@endif</span></td>--}}
                        <td class="text-right">{{number_format($o->total_items)}}</td>
						<td class="text-right" style="color:green;"></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>