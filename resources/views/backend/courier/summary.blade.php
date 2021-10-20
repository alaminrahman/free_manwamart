@extends('layouts.app')
@section('title', __('lang_v1.ledger'))

@section('content')
    @if(!empty($for_pdf))
        <link rel="stylesheet" href="{{ asset('css/app.css?v='.$asset_v) }}">
    @endif
    <style>
        #ledger_table td {
            padding: 5px !important;
        }
    </style>
    <section class="content">
        <div class="row no-print">
            <form action="{{action('CourierController@summary')}}">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('sell_list_filter_date_range', __('report.date_range') . ':') !!}
                        {!! Form::text('date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'),'id'=>'sell_list_filter_date_range', 'class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" id="submit" style="margin-top: 20px" class="btn btn-primary">Show</button>
                </div>
            </form>
        </div >
        <div class="row">
            <div class="col-md-12 col-sm-12 @if(!empty($for_pdf)) width-100 align-right @endif">
                <p class="text-center"><strong>Courier Summary </strong></p>
                <p  class="text-center"> Date: {{@format_datetime($start)}} - {{@format_datetime($end)}}</p>
            </div>
            <div class="col-md-12 col-sm-12 @if(!empty($for_pdf)) width-100 @endif">
                <table class="table table-striped table-bordered @if(!empty($for_pdf)) table-pdf td-border @endif" id="ledger_table">
                    <thead>
                    <tr class="row-border blue-heading">
                        <th>Courier name</th>
                        <th>Total order</th>
                        <th class="text-center">Total items</th>
                        <th class="text-center">Total amount</th>
                        <th class="text-center">Amount paid</th>
                        <th class="text-center">Amount due</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $total_order = 0;
                        $total_items = 0;
                        $total_amount = 0;
                        $total_paid = 0;
                    @endphp
                    @foreach($couriers as $c)
                        @php
                        $orders = $c->transactions->count();
                        $items = $c->transactions->sum('total_items');
                        $amount = $c->transactions->sum('final_total');
                        $paid = $c->transactions->where('courier_payment_status','Paid')->sum('final_total');
                        $total_order += $orders;
                        $total_items += $items;
                        $total_amount += $amount;
                        $total_paid += $paid;
                        @endphp
                        <tr>
                            <td>{{$c->name}}</td>
                            <td>{{$orders}}</td>
                            <td>{{$items}}</td>
                            <td class="text-right display_currency">{{$amount}}</td>
                            <td class="text-right display_currency">{{$paid}}</td>
                            <td class="text-right display_currency">{{$amount - $paid}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-3 table-bordered">
                <table class="table">
                    <tr>
                        <th>Total Orders</th>
                        <td>{{$total_order}}</td>
                    </tr>
                    <tr>
                        <th>Total Items</th>
                        <td>{{$total_items}}</td>
                    </tr>
                    <tr>
                        <th>Total amount</th>
                        <td class="display_currency">{{$total_amount}}</td>
                    </tr>
                    <tr>
                        <th>Total paid</th>
                        <td class="display_currency">{{$total_paid}}</td>
                    </tr>
                    <tr>
                        <th>Total due</th>
                        <td class="display_currency">{{$total_amount - $total_paid}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </section>

@stop
@section('javascript')
    <script type="text/javascript">
        $(document).ready( function() {
            var element = $('table');
            __currency_convert_recursively(element);
            $('#sell_list_filter_date_range').daterangepicker(
                {
                    ranges: ranges,
                    startDate: moment('{{\Carbon\Carbon::createFromFormat('Y-m-d  H:i:s',$start)->toDateString()}}'),
                    endDate: moment('{{\Carbon\Carbon::createFromFormat('Y-m-d  H:i:s',$end)->toDateString()}}'),
                    locale: {
                        cancelLabel: LANG.clear,
                        applyLabel: LANG.apply,
                        customRangeLabel: LANG.custom_range,
                        format: moment_date_format,
                        toLabel: '~',
                    },
                },
                function (start, end) {
                    $('#sell_list_filter_date_range').val(start.format(moment_date_format) + ' - ' + end.format(moment_date_format));
                }
            );
            $('#sell_list_filter_date_range').on('cancel.daterangepicker', function (ev, picker) {
                $('#sell_list_filter_date_range').val('');
            });
        });
        $(document).on('click', '#submit', function (e) {
            e.preventDefault();
            var url = "{{action('CourierController@summary')}}?location_id=";
            if($('#sell_list_filter_date_range').val()) {
                var start = $('#sell_list_filter_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var end = $('#sell_list_filter_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                url+="&start="+start+"&end="+end;
            }
            window.location.href = url;
        })
    </script>
    @endsection