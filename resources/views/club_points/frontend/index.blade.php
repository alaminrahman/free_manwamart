@extends('frontend.layouts.app')

@section('content')
    @php
        $club_point_convert_rate = \App\BusinessSetting::where('type', 'club_point_convert_rate')->first()->value;
    @endphp
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')

                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('My Points') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 mx-auto">
                            <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
                                <div class="px-3 pt-3 pb-3">
                                    <div class="h3 fw-700 text-center">{{ $club_point_convert_rate }} {{ translate(' Points') }} = {{ single_price(1) }} {{ translate('Wallet Money') }}</div>
                                    <div class="opacity-50 text-center">{{ translate('Exchange Rate') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Point Earning history')}}</h5>
                        </div>
                          <div class="card-body">
                              <table class="table aiz-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{translate('Order Code')}}</th>
                                        <th data-breakpoints="lg">{{translate('Points')}}</th>
                                        <th data-breakpoints="lg">{{translate('Converted')}}</th>
                                        <th data-breakpoints="lg">{{translate('Date') }}</th>
                                        <th class="text-right">{{translate('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($club_points as $key => $club_point)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>
                                            @if ($club_point->order != null)
                                                    {{ $club_point->order->code }}
                                                @else
                                                    {{ translate('Order not found') }}
                                                @endif
                                            </td>
                                            <td>{{ $club_point->points }} {{ translate(' pts') }}</td>
                                            <td>
                                                @if ($club_point->convert_status == 1)
                                                    <span class="badge badge-inline badge-success">{{ translate('Yes') }}</strong></span>
                                                @else
                                                    <span class="badge badge-inline badge-info">{{ translate('No') }}</strong></span>
                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($club_point->created_at)) }}</td>

                                            <td class="text-right">
                                                @if ($club_point->convert_status == 0)
                                                    <button onclick="convert_point({{ $club_point->id }})" class="btn btn-sm btn-styled btn-primary">{{translate('Convert Now')}}</button>
                                                @else
                                                  <span class="badge badge-inline badge-success">{{ translate('Done') }}</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                              </table>
                              <div class="aiz-pagination">
                                  {{ $club_points->links() }}
                              </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        function convert_point(el)
        {
            $.post('{{ route('convert_point_into_wallet') }}',{_token:'{{ csrf_token() }}', el:el}, function(data){
                if (data == 1) {
                    location.reload();
                    AIZ.plugins.notify('success', '{{ translate('Convert has been done successfully Check your Wallets') }}');
                }
                else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
    		});
        }
    </script>
@endsection
