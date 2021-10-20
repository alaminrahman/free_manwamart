@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Rejected Request')}}</h5>
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
                    <th>{{translate('Admin Approval')}}</th>
                    <th data-breakpoints="lg">{{translate('Reject Reason')}}</th>
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
                            @if($refund->admin_approval == 2)
                                <span class="badge badge-inline badge-danger">{{translate('Rejected')}}</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="javascript:void(0);" onclick="refund_reject_reason_show('{{ route('reject_reason_show', $refund->id )}}')" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('Reject Reason') }}">
                                <i class="las la-eye"></i>
                            </a>
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

@section('modal')
<div class="modal fade reject_reason_show_modal" id="modal-basic">
	<div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title h6">{{translate('Refund Request Reject Reason')}}</h5>
              <button type="button" class="close" data-dismiss="modal"></button>
          </div>
          <div class="modal-body reject_reason_show">
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
          </div>
      </div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  function refund_reject_reason_show(url){
      $.get(url, function(data){
          $('.reject_reason_show').html(data);
          $('.reject_reason_show_modal').modal('show');
      });
  }
</script>
@endsection
