@extends('frontend.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')

                <div class="aiz-user-panel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Refund Request') }}</h5>
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
                                        <th data-breakpoints="lg">{{translate('Status')}}</th>
                                        <th data-breakpoints="lg">{{translate('Reason')}}</th>
                                        <th>{{translate('Approval')}}</th>
                                        <th data-breakpoints="lg">{{translate('Reject')}}</th>
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
                                                @if($refund->refund_status == 1)
                                                  <span class="badge badge-inline badge-success"><strong>{{translate('Approved')}}</strong></span>
                                                @elseif($refund->refund_status == 2)
                                                  <span class="badge badge-inline badge-danger"><strong>{{translate('Rejected')}}</strong></span>
                                                @else
                                                  <span class="badge badge-inline badge-warning"><strong>{{translate('PENDING')}}</strong></span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('reason_show', $refund->id) }}"><span class="badge badge-inline badge-success">{{translate('Show')}}</span></a>
                                            </td>
                                            <td>
                                              @if($refund->refund_status != 2 && $refund->seller_approval != 2)
                                                @if ($refund->seller_approval == 1)
                                                    <label class="aiz-switch aiz-switch-success mb-0 ">
                                                        <input type="checkbox" @if ($refund->seller_approval == 1) checked  @endif>
                                                        <span class="slider round"></span>
                                                    </label>
                                                @else
                                                    <label class="aiz-switch aiz-switch-success mb-0">
                                                        <input onchange="update_refund_approval('{{ $refund->id }}')" type="checkbox" @if ($refund->seller_approval == 1) checked @endif>
                                                        <span class="slider round"></span>
                                                    </label>
                                                @endif
                                              @endif
                                            </td>
                                            <td>
                                              @if($refund->refund_status == 0 && $refund->seller_approval == 0)
                                                <a class="btn btn-soft-danger btn-icon btn-circle btn-sm" onclick="reject_refund_request({{$refund->id}})" title="{{ translate('Reject Refund Request') }}">
                                                    <i class="las la-trash"></i>
                                                </a>
                                              @elseif($refund->seller_approval == 2 || $refund->refund_status == 2)
                                                <a href="javascript:void(0);" onclick="refund_reject_reason_show('{{ route('reject_reason_show', $refund->id )}}')" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('Reject Reason') }}">
                                                    <i class="las la-eye"></i>
                                                </a>
                                              @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="aiz-pagination">
                                {{ $refunds->links() }}
                          	</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modal')
  <div class="modal fade reject_refund_request" id="modal-basic">
    	<div class="modal-dialog">
    		<div class="modal-content">
            <form class="form-horizontal member-block" action="{{ route('reject_refund_request')}}" method="POST">
                @csrf
                <input type="hidden" name="refund_id" id="refund_id" value="">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{translate('Reject Refund Request !')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Reject Reason')}}</label>
                        <div class="col-md-9">
                            <textarea type="text" name="reject_reason" rows="5" class="form-control" placeholder="{{translate('Reject Reason')}}" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
                    <button type="submit" class="btn btn-success">{{translate('Submit')}}</button>
                </div>
            </form>
      	</div>
    	</div>
    </div>
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

        function update_refund_approval(el){
            $.post('{{ route('vendor_refund_approval') }}',{_token:'{{ @csrf_token() }}', el:el}, function(data){
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Approval has been done successfully') }}');
                }
                else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function reject_refund_request(id){
           $('.reject_refund_request').modal('show');
           $('#refund_id').val(id);
         }

         function refund_reject_reason_show(url){
             $.get(url, function(data){
                 $('.reject_reason_show').html(data);
                 $('.reject_reason_show_modal').modal('show');
             });
         }
    </script>
@endsection
