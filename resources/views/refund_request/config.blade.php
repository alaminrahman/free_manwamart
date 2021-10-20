@extends('backend.layouts.app')

@section('content')

@php
    $refund_time_config = \App\BusinessSetting::where('type', 'refund_request_time')->first();
@endphp
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Set Refund Time')}}</h5>
            </div>
            <form class="form-horizontal" action="{{ route('refund_request_time_config') }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <div class="card-body">
                    <div class="form-group row">
                        <input type="hidden" name="type" value="refund_request_time">
                        <label class="col-lg-4 col-from-label">{{translate('Set Time for sending Refund Request')}}</label>
                        <div class="col-lg-5">
                            <input type="number" min="0" step="1" @if ($refund_time_config != null) value="{{ $refund_time_config->value }}" @endif placeholder="" name="value" class="form-control">
                        </div>
                        <div class="col-lg-3">
                            <option class="form-control">days</option>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 h6">{{translate('Set Refund Sticker')}}</h6>
            </div>
            <form class="form-horizontal" action="{{ route('refund_sticker_config') }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <div class="card-body">
                  <div class="form-group row">
                    <input type="hidden" name="type" value="refund_sticker">
                      <label class="col-md-2 col-form-label" for="signinSrEmail">{{translate('Sticker')}}</label>
                      <div class="col-md-10">
                          <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                              <div class="input-group-prepend">
                                  <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                              </div>
                              <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                              <input type="hidden" name="logo" class="selected-files" value="{{ get_setting('refund_sticker') }}">
                          </div>
                          <div class="file-preview box sm">
                          </div>
                      </div>
                    </div>

                    <!-- <div class="form-group row">
                        <input type="hidden" name="type" value="refund_sticker">
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label" for="logo">{{translate('Sticker')}}</label>
                            <div class="col-lg-5">
                                <input type="file" id="logo" name="logo" class="form-control">
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection
