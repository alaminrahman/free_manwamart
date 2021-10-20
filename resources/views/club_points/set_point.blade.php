@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body px-3">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Name')}}</th>
                            <th data-breakpoints="lg">{{translate('Owner')}}</th>
                            <th data-breakpoints="lg">{{translate('Price')}}</th>
                            <th data-breakpoints="lg">{{translate('Point')}}</th>
                            <th>{{translate('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $key => $product)
                            <tr>
                                <td>{{ ($key+1) + ($products->currentPage() - 1)*$products->perPage() }}</td>
                                <td>
                                    <a href="{{ route('product', $product->slug) }}" target="_blank">
                      								<div class="form-group row">
                      									<div class="col-auto">
                      										<img src="{{ uploaded_asset($product->thumbnail_img)}}" alt="Image" class="size-50px">
                      									</div>
                      									<div class="col">
                      										<span class="text-muted text-truncate-2">{{ $product->getTranslation('name') }}</span>
                      									</div>
                      								</div>
                    							  </a>
                                </td>
                                <td>
                                  @if ($product->user != null)
                                      {{ $product->user->name }}
                                  @endif
                                </td>
                                <td>{{ number_format($product->unit_price,2) }}</td>
                                <td>{{ $product->earn_point }}</td>
                                <td class="text-right">
                  								<a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('product_club_point.edit', encrypt($product->id))}}" title="{{ translate('Edit') }}">
                  									<i class="las la-edit"></i>
                  								</a>
			                           </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $products->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
          <div class="card">
              <div class="card-header">
                  <h5 class="mb-0 h6">{{translate('Set Point for Product Within a Range')}}</h5>
              </div>
              <div class="card-body">
                  <div class="mb-3 text-muted">
                      <small>{{ translate('Set any specific point for those products what are between Min-price and Max-price. Min-price should be less than Max-price') }}</small>
                  </div>
                  <form class="form-horizontal" action="{{ route('set_products_point.store') }}" method="POST">
                      @csrf
                      <div class="form-group row">
                          <div class="col-lg-6">
                              <label class="col-from-label">{{translate('Set Point for multiple products')}}</label>
                          </div>
                          <div class="col-lg-6">
                              <input type="number" min="0" step="0.01" class="form-control" name="point" placeholder="100" required>
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-lg-6">
                              <label class="col-from-label">{{translate('Min Price')}}</label>
                          </div>
                          <div class="col-lg-6">
                              <input type="number" min="0" step="0.01" class="form-control" name="min_price" value="{{ \App\Product::min('unit_price') }}" placeholder="50" required>
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-lg-6">
                              <label class="col-from-label">{{translate('Max Price')}}</label>
                          </div>
                          <div class="col-lg-6">
                              <input type="number" min="0" step="0.01" class="form-control" name="max_price" value="{{ \App\Product::max('unit_price') }}" placeholder="110" required>
                          </div>
                      </div>
                      <div class="form-group mb-0 text-right">
                          <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                      </div>
                  </form>
              </div>
          </div>
          <div class="card">
              <div class="card-header">
                  <h5 class="mb-0 h6">{{translate('Set Point for all Products')}}</h5>
              </div>
              <div class="card-body">
                  <form class="form-horizontal" action="{{ route('set_all_products_point.store') }}" method="POST">
                      @csrf
                      <div class="form-group row">
                          <div class="col-lg-4">
                              <label class="col-from-label">{{translate('Set Point For ')}} {{ single_price(1) }}</label>
                          </div>
                          <div class="col-lg-6">
                              <input type="number" step="0.001" class="form-control" name="point" placeholder="1" required>
                          </div>
                          <div class="col-lg-2">
                              <label class="col-from-label">{{translate('Points')}}</label>
                          </div>
                      </div>
                      <div class="form-group mb-0 text-right">
                          <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                      </div>
                  </form>
              </div>
          </div>
    </div>
</div>

@endsection
