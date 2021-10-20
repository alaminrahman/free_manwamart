@extends('frontend.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{translate('Send Refund Request')}}</h5>
                        </div>
                        <div class="card-body">
                          <form class="" action="{{route('refund_request_send', $order_detail->id)}}" method="POST" enctype="multipart/form-data" id="choice_form">
                              @csrf
                              <div class="form-box bg-white mt-4">
                                  <div class="form-box-content p-3">
                                      <div class="row">
                                          <div class="col-md-3">
                                              <label>{{translate('Product Name')}} <span class="text-danger">*</span></label>
                                          </div>
                                          <div class="col-md-9">
                                              <input type="text" class="form-control mb-3" name="name" placeholder="{{translate('Product Name')}}" value="{{ $order_detail->product->getTranslation('name') }}" readonly>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-3">
                                              <label>{{translate('Product Price')}} <span class="text-danger">*</span></label>
                                          </div>
                                          <div class="col-md-9">
                                              <input type="number" class="form-control mb-3" name="name" placeholder="{{translate('Product Price')}}" value="{{ $order_detail->product->unit_price }}" readonly>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-3">
                                              <label>{{translate('Order Code')}} <span class="text-danger">*</span></label>
                                          </div>
                                          <div class="col-md-9">
                                              <input type="text" class="form-control mb-3" name="code" value="{{ $order_detail->order->code }}" readonly>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-3">
                                              <label>{{translate('Refund Reason')}} <span class="text-danger">*</span></label>
                                          </div>
                                          <div class="col-md-9">
                                              <textarea name="reason" rows="8" class="form-control mb-3"></textarea>
                                          </div>
                                      </div>
                                      <div class="form-group mb-0 text-right">
                                          <button type="submit" class="btn btn-primary">{{translate('Send Request')}}</button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
