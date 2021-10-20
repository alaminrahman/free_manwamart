<div class="row">
  <div class="col-xs-12 text-center">
    <h1>{{$as->courier->name}}</h1>
  </div>
  <div class="col-xs-12">
    <h2 class="page-header">
      @lang('custom.courier_data') (<b>@lang('purchase.ref_no'):</b> #{{ $as->ref_no }})
      <small class="pull-right"><b>@lang('messages.date'):</b> {{ @format_date($as->date) }}</small>
    </h2>
  </div>
</div>
<div class="row invoice-info">
{{--  <div class="col-sm-4 invoice-col">--}}
{{--    @lang('lang_v1.location_from'):--}}
{{--    <address>--}}
{{--      <strong>{{ $location_details['sell']->name }}</strong>--}}
{{--      --}}
{{--      @if(!empty($location_details['sell']->landmark))--}}
{{--        <br>{{$location_details['sell']->landmark}}--}}
{{--      @endif--}}

{{--      @if(!empty($location_details['sell']->city) || !empty($location_details['sell']->state) || !empty($location_details['sell']->country))--}}
{{--        <br>{{implode(',', array_filter([$location_details['sell']->city, $location_details['sell']->state, $location_details['sell']->country]))}}--}}
{{--      @endif--}}

{{--      @if(!empty($sell_transfer->contact->tax_number))--}}
{{--        <br>@lang('contact.tax_no'): {{$sell_transfer->contact->tax_number}}--}}
{{--      @endif--}}

{{--      @if(!empty($location_details['sell']->mobile))--}}
{{--        <br>@lang('contact.mobile'): {{$location_details['sell']->mobile}}--}}
{{--      @endif--}}
{{--      @if(!empty($location_details['sell']->email))--}}
{{--        <br>Email: {{$location_details['sell']->email}}--}}
{{--      @endif--}}
{{--    </address>--}}
{{--  </div>--}}

{{--  <div class="col-md-4 invoice-col">--}}
{{--    @lang('lang_v1.location_to'):--}}
{{--    <address>--}}
{{--      <strong>{{ $location_details['purchase']->name }}</strong>--}}
{{--      --}}
{{--      @if(!empty($location_details['purchase']->landmark))--}}
{{--        <br>{{$location_details['purchase']->landmark}}--}}
{{--      @endif--}}

{{--      @if(!empty($location_details['purchase']->city) || !empty($location_details['purchase']->state) || !empty($location_details['purchase']->country))--}}
{{--        <br>{{implode(',', array_filter([$location_details['purchase']->city, $location_details['purchase']->state, $location_details['purchase']->country]))}}--}}
{{--      @endif--}}

{{--      @if(!empty($sell_transfer->contact->tax_number))--}}
{{--        <br>@lang('contact.tax_no'): {{$sell_transfer->contact->tax_number}}--}}
{{--      @endif--}}

{{--      @if(!empty($location_details['purchase']->mobile))--}}
{{--        <br>@lang('contact.mobile'): {{$location_details['purchase']->mobile}}--}}
{{--      @endif--}}
{{--      @if(!empty($location_details['purchase']->email))--}}
{{--        <br>Email: {{$location_details['purchase']->email}}--}}
{{--      @endif--}}
{{--    </address>--}}
{{--  </div>--}}

  <div class="col-sm-4 invoice-col">
    <b>@lang('purchase.ref_no'):</b> #{{ $as->ref_no }}<br/>
    <b>@lang('messages.date'):</b> {{ @format_date($as->date) }}<br/>
  </div>
</div>

<br>
<div class="row">
  <div class="col-xs-12">
    <div class="table-responsive">
      <table class="table bg-gray">
        <tr class="bg-green">
          <th>#</th>
          <th>@lang('sale.invoice_no')</th>
          <th>@lang('contact.customer')</th>
          <th>@lang('business.address')</th>
          <th>@lang('contact.mobile')</th>
          <th>@lang('sale.amount')</th>
{{--          <th class="text-center">--}}
{{--            @lang('custom.payment_type')--}}
{{--          </th>--}}
{{--          <th>@lang('purchase.payment_status')</th>--}}
          <th>Total items</th>
        </tr>
        @php
         $total_item = 0;
        $total_amount = 0;
        @endphp
        @foreach($list as $o)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              {{$o->invoice_no}}
            </td>
            <td>{{$o->name}}</td>
            <td>{{$o->address}}</td>
            <td>{{$o->mobile}}</td>
            <td>{{$o->payment_type == 'full_paid'  || $o->payment_type == 'other'? 0:number_format($o->final_total,2)}}</td>
{{--            <td class="text-center">{{$o->payment_type?__('custom.'.$o->payment_type): $o->wp_payment_data}}</td>--}}
{{--            <td class="text-center">{{$o->courier_payment_status}}</td>--}}
            <td class="text-right">{{number_format($o->total_items)}}</td>
          </tr>
          @php

            $total_item += $o->total_items;
            $total_amount+= $o->final_total;
          @endphp
        @endforeach
      </table>
    </div>
  </div>
  <div class="col-xs-6 col-xs-offset-6">
    <table class="table bg-gray">
      <tr>
        <td class="text-right">Total amount</td>
        <td class="text-right">{{ number_format($total_amount,2)}}</td>
      </tr>
      <tr>
        <td class="text-right">Total parcel</td>
        <td class="text-right">{{ number_format(count($list),2)}}</td>
      </tr>
      <tr>
        <td class="text-right">Total items</td>
        <td class="text-right">{{ number_format($total_item,2)}}</td>
      </tr>
    </table>
  </div>
</div>
<br>
<div class="row">
  <div class="col-sm-6">
    <strong>@lang('purchase.additional_notes'):</strong><br>
    <p class="well well-sm no-shadow bg-gray">
      @if($as->note)
        {{ $as->note }}
      @else
        --
      @endif
    </p>
  </div>
</div>

{{-- Barcode --}}
<div class="row print_section">
  <div class="col-xs-12">
    <img class="center-block" src="data:image/png;base64,{{DNS1D::getBarcodePNG($as->ref_no, 'C128', 2,30,array(39, 48, 54), true)}}">
  </div>
</div>