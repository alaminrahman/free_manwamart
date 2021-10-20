@extends('frontend.layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.inc.user_side_nav')
            <div class="aiz-user-panel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Applied Refund Request') }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table aiz-table mb-0">
                            <thead>
                                <tr>
                                  <th>#</th>
                                  <th data-breakpoints="lg">{{ translate('Date') }}</th>
                                  <th>{{translate('Order id')}}</th>
                                  <th data-breakpoints="lg">{{translate('Product')}}</th>
                                  <th data-breakpoints="lg">{{translate('Amount')}}</th>
                                  <th>{{translate('Status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                  @foreach ($refunds as $key => $refund)
                                      <tr>
                                          <td>{{ $key+1 }}</td>
                                          <td>{{ date('d-m-Y', strtotime($refund->created_at)) }}</td>
                                          <td>
                                              @if ($refund->order != null)
                                                  {{ $refund->order->code }}
                                              @endif
                                          </td>
                                          <td>
                                              @if ($refund->orderDetail != null && $refund->orderDetail->product != null)
                                                  {{ $refund->orderDetail->product->getTranslation('name') }}
                                              @endif
                                          </td>
                                          <td>
                                              @if ($refund->orderDetail != null)
                                                  {{single_price($refund->orderDetail->price)}}
                                              @endif
                                          </td>
                                          <td>
                                              @if ($refund->refund_status == 1)
                                                  <span class="badge badge-inline badge-success">{{translate('Approved')}}</span>
                                              @elseif ($refund->refund_status == 2)
                                                  <span class="badge badge-inline badge-danger">{{translate('REJECTED')}}</span>
                                                  <a href="javascript:void(0);" onclick="refund_reject_reason_show('{{ route('reject_reason_show', $refund->id )}}')" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('Reject Reason') }}">
                                                      <i class="las la-eye"></i>
                                                  </a>
                                              @else
                                                  <span class="badge badge-inline badge-info">{{translate('PENDING')}}</span>
                                              @endif
                                          </td>
                                      </tr>
                                  @endforeach
                            </tbody>
                        </table>
                        {{ $refunds->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
