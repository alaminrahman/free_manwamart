@extends('layouts.app')
@section('title', __('lang_v1.import_opening_stock'))

@section('content')
<br/>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Upload pathao file</h1>
</section>

<!-- Main content -->
<section class="content">
    
@if (session('notification') || !empty($notification))
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                @if(!empty($notification['msg']))
                    {{$notification['msg']}}
                @elseif(session('notification.msg'))
                    {{ session('notification.msg') }}
                @endif
              </div>
          </div>  
      </div>     
@endif
    <div class="row">
        <div class="col-sm-12">
            @component('components.widget', ['class' => 'box-primary'])
                {!! Form::open(['url' => action('CourierAssigmentController@uploadPathaoPost'), 'method' => 'post', 'enctype' => 'multipart/form-data' ]) !!}
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                {!! Form::label('name', __( 'product.file_to_import' ) . ':') !!}
                                @show_tooltip(__('lang_v1.tooltip_import_opening_stock'))
                                {!! Form::file('products_csv', ['accept'=> '.xls, .csv', 'required' => 'required']); !!}
                              </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('account_id', __('account.account').':*') !!}
                                {!! Form::select('account_id', $accounts, '', ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required', 'id' => 'account_id']); !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <br>
                            <button type="submit" class="btn btn-primary">@lang('messages.submit')</button>
                        </div>
                    </div>

                {!! Form::close() !!}
                <div class="row">
                    <div class="col-sm-4">
                        <a href="{{ asset('files/pathao_report_csv_template.csv') }}" class="btn btn-success" download><i class="fa fa-download"></i> @lang('lang_v1.download_template_file')</a>
                    </div>
                </div>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            @component('components.widget', ['class' => 'box-primary', 'title' => __('lang_v1.instructions')])
            <strong>You can make pathao similiar to template by removing other field.</strong>
                <br><br>
                <table class="table table-striped">
                    <tr>
                        <th>@lang('lang_v1.col_no')</th>
                        <th>@lang('lang_v1.col_name')</th>
                        <th>@lang('lang_v1.instruction')</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Consignment_ID <small class="text-muted">(@lang('lang_v1.required'))</small></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Final_Fee <small class="text-muted">(@lang('lang_v1.required'))</small></td>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Collected_amount <small class="text-muted">(@lang('lang_v1.required'))</small></td>
                        </td>
                    </tr>
                </table>
        @endcomponent
        </div>
    </div>
</section>
<!-- /.content -->

@endsection