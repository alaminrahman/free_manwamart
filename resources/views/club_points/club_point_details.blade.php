@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{translate('Product Name')}}</th>
                                <th>{{translate('Points')}}</th>
                                <th data-breakpoints="lg">{{translate('Earned At')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($club_point_details as $key => $club_point)
                                <tr>
                                    <td>{{ ($key+1) + ($club_point_details->currentPage() - 1)*$club_point_details->perPage() }}</td>
                                    @if ($club_point->product != null)
                                        <td>{{ $club_point->product->getTranslation('name') }}</td>
                                    @else
                                        <td>{{ translate('Deleted Product') }}</td>
                                    @endif
                                    <td>{{ $club_point->point }}</td>
                                    <td>{{ $club_point->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="clearfix">
                        <div class="pull-right">
                            {{ $club_point_details->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
