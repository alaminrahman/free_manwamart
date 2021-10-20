@extends('layouts.app')
@section('title', __('custom.courier'))

@section('content')
<section class="content-header">
    <h1>@lang('custom.courier')
    </h1>
</section>
<section class="content">
    <div class="row">
    <div class="col-md-12">
        @component('components.widget')
        @can('account.report')
        <div class="col-md-8">
            <button type="button" class="btn btn-primary m-2 btn-modal pull-right"
                    data-container=".account_model"
                    data-href="{{action('CourierController@create')}}">
                <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
            <a class="btn btn-primary m-2 pull-right"
                    href="{{action('CourierController@summary')}}">
                <i class="fa fa-chart-bar"></i> @lang( 'report.summary' )</a>
        </div>
        @endcan
        @endcomponent
    </div>
    <div class="col-sm-12">
        <br>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="other_account_table">
                <thead>
                <tr>
                    <th>@lang( 'lang_v1.name' )</th>
                    <th>@lang( 'messages.action' )</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
        <div class="modal fade account_model" tabindex="-1" role="dialog"
             aria-labelledby="gridSystemModalLabel">
        </div>
</div>
</section>
@endsection
@section('javascript')
    <script>
        $(document).ready(function(){

            $(document).on('click', 'button.close_account', function(){
                swal({
                    title: LANG.sure,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete)=>{
                    if(willDelete){
                        var url = $(this).data('url');

                        $.ajax({
                            method: "delete",
                            url: url,
                            dataType: "json",
                            success: function(result){
                                if(result.success == true){
                                    toastr.success(result.msg);
                                    capital_account_table.ajax.reload();
                                    other_account_table.ajax.reload();
                                }else{
                                    toastr.error(result.msg);
                                }

                            }
                        });
                    }
                });
            });

            $(document).on('submit', 'form#payment_account_form', function(e){
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    method: "post",
                    url: $(this).attr("action"),
                    dataType: "json",
                    data: data,
                    success:function(result){
                        if(result.success == true){
                            $('div.account_model').modal('hide');
                            toastr.success(result.msg);
                            capital_account_table.ajax.reload();
                            other_account_table.ajax.reload();
                        }else{
                            toastr.error(result.msg);
                        }
                    }
                });
            });

            // capital_account_table
            capital_account_table = $('#other_account_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/courier',
                columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action'}
                ],
                "fnDrawCallback": function (oSettings) {
                    __currency_convert_recursively($('#capital_account_table'));
                }
            });

        });

        $('.account_model').on('shown.bs.modal', function(e) {
            $('.account_model .select2').select2({ dropdownParent: $(this) })
        });
    </script>
@endsection