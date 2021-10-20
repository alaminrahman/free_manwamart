@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Approved Request')}}</h5>
    </div>
    <div class="card-body">
        <table class="table aiz-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{translate('Order Code')}}</th>
                    <th data-breakpoints="lg">{{translate('Seller Name')}}</th>
                    <th data-breakpoints="lg">{{translate('Product')}}</th>
                    <th data-breakpoints="lg">{{translate('Price')}}</th>
                    <th data-breakpoints="lg">{{translate('Seller Approval')}}</th>
                    <th data-breakpoints="lg">{{translate('Admin Approval')}}</th>
                    <th>{{translate('Refund Status')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($refunds as $key => $refund)
                    <tr>
                        <td>{{ ($key+1) + ($refunds->currentPage() - 1)*$refunds->perPage() }}</td>
                        <td>
                          @if($refund->order != null)
                              {{ $refund->order->code }}
                          @else
                              {{ translate('Order deleted') }}
                          @endif
                        </td>
                        <td>
                            @if ($refund->seller != null)
                                {{ $refund->seller->name }}
                            @endif
                        </td>
                        <td>
                            @if ($refund->orderDetail != null && $refund->orderDetail->product != null)
                              <a href="{{ route('product', $refund->orderDetail->product->slug) }}" target="_blank" class="media-block">
                                <div class="form-group row">
                                  <div class="col-md-5">
                                    <img src="{{ uploaded_asset($refund->orderDetail->product->thumbnail_img)}}" alt="Image" class="w-50px">
                                  </div>
                                  <div class="col-md-7">
                                    <div class="media-body">{{ $refund->orderDetail->product->getTranslation('name') }}</div>
                                  </div>
                                </div>
                              </a>
                            @endif
                        </td>
                        <td>
                            @if ($refund->orderDetail != null)
                                {{single_price($refund->orderDetail->price)}}
                            @endif
                        </td>
                        <td>
                            @if ($refund->seller_approval == 1)
                              <span class="badge badge-inline badge-success">{{translate('Approved')}}</span>
                            @else
                              <span class="badge badge-inline badge-warning">{{translate('Pending')}}</span>
                            @endif
                        </td>
                        <td>
                            @if ($refund->admin_approval == 1)
                              <span class="badge badge-inline badge-success">{{translate('Approved')}}</span>
                            @endif
                        </td>
                        <td>
                            @if ($refund->refund_status == 1)
                              <span class="badge badge-inline badge-success">{{translate('Paid')}}</span>
                            @else
                              <span class="badge badge-inline badge-warning">{{translate('Non-Paid')}}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="clearfix">
            <div class="pull-right">
                {{ $refunds->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
