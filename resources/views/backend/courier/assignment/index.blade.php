@extends('layouts.app')
@section('title', __('custom.bulk_assignment'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header no-print">
        <h1>@lang('custom.bulk_assignment')
        </h1>
    </section>

    <!-- Main content -->
    <section class="content no-print">
        @component('components.widget', ['class' => 'box-primary', 'title' => __('custom.bulk_assignment')])
            @slot('tool')
                <div class="box-tools">
                    <a class="btn btn-block btn-primary" href="{{action('CourierAssigmentController@create')}}">
                        <i class="fa fa-plus"></i> @lang('custom.assign_courier')</a>
                </div>
            @endslot
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="assignment_list">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>@lang('messages.date')</th>
                        <th>@lang('lang_v1.pay_reference_no')</th>
                        <th>@lang('custom.courier')</th>
                        <th>@lang('lang_v1.total_items')</th>
                        <th>@lang('sale.amount')</th>
                        <th>@lang('business.created_by')</th>
                        <th>@lang('purchase.additional_notes')</th>
                        <th>@lang('messages.action')</th>
                    </tr>
                    </thead>
                </table>
            </div>
        @endcomponent
    </section>

    <section id="receipt_section" class="print_section"></section>

    <!-- /.content -->
@stop
@section('javascript')
{{--    <script src="{{ asset('js/stock_transfer.js?v=' . $asset_v) }}"></script>--}}
    <script>
        assignment_list = $('#assignment_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/courier-assignment',
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    searchable: false,
                    "visible": false,
                },
                {
                    targets: 7,
                    orderable: false,
                    searchable: false,
                },
            ],
            columns: [
                { data: 'id', name:'id'},
                { data: 'date', name: 'date' },
                { data: 'ref_no', name: 'ref_no' },
                { data: 'courier_name', name: 'courier_name' },
                { data: 'total_order', name: 'total_order' },
                { data: 'total_amount', name: 'total_amount' },
                { data: 'created_by', name: 'created_by' },
                { data: 'note', name: 'note' },
                { data: 'action', name: 'action' },
            ],
            fnDrawCallback: function(oSettings) {
                __currency_convert_recursively($('#assignment_list'));
            },
        });
        var detailRows = [];

        $('#assignment_list tbody').on('click', '.view_stock_transfer', function() {
            var tr = $(this).closest('tr');
            var row = assignment_list.row(tr);
            var idx = $.inArray(tr.attr('id'), detailRows);

            if (row.child.isShown()) {
                $(this)
                    .find('i')
                    .removeClass('fa-eye')
                    .addClass('fa-eye-slash');
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice(idx, 1);
            } else {
                $(this)
                    .find('i')
                    .removeClass('fa-eye-slash')
                    .addClass('fa-eye');

                row.child(get_details(row.data())).show();

                // Add to the 'open' array
                if (idx === -1) {
                    detailRows.push(tr.attr('id'));
                }
            }
        });

        // On each draw, loop over the `detailRows` array and show any child rows
        assignment_list.on('draw', function() {
            $.each(detailRows, function(i, id) {
                $('#' + id + ' .view_stock_transfer').trigger('click');
            });
        });
        function get_details(rowData) {
            var div = $('<div/>')
                .addClass('loading')
                .text('Loading...');
            $.ajax({
                url: '/courier-assignment/' + rowData.id,
                dataType: 'html',
                success: function(data) {
                    div.html(data).removeClass('loading');
                },
            });

            return div;
        }
        $(document).on('click', 'button.delete_stock_transfer', function() {
            swal({
                title: LANG.sure,
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then(willDelete => {
                if (willDelete) {
                    var href = $(this).data('href');
                    $.ajax({
                        method: 'DELETE',
                        url: href,
                        dataType: 'json',
                        success: function(result) {
                            if (result.success) {
                                toastr.success(result.msg);
                                assignment_list.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                }
            });
        });
    </script>
@endsection