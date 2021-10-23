@extends('backend.layouts.app')

@section('content')
<div class="add-sell mb-2" style="border-bottom:3px solid #ac8bce"><h4>Add Sale</h4></div>
<section class="">
    <form class="" action="{{ route('addsell_store') }}" method="POST" enctype="multipart/form-data">
        @csrf
 
        <div class="row gutters-5">
            <div class="col-md">
                <div class="row gutters-5 mb-3">
                    <div class="col-md-11 mb-2 mb-md-0">
                        <div class="form-group mb-0">
                            <input class="form-control form-control-lg" type="text" name="keyword" placeholder="Search by Product Name/Barcode" onkeyup="filterProducts()">
                        </div>
                    </div>


                    <!-- <div class="col-md-3 col-6">
                        <select name="poscategory" class="form-control form-control-lg aiz-selectpicker" data-live-search="true" onchange="filterProducts()">
                            <option value="">All Categories</option>
                            @foreach (\App\Category::all() as $key => $category)
                                <option value="category-{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                            @endforeach
                        </select>
                    </div> -->
                    <!-- <div class="col-md-3 col-6">
                        <select name="brand"  class="form-control form-control-lg aiz-selectpicker" data-live-search="true" onchange="filterProducts()">
                            <option value="">All Brands</option>
                            @foreach (\App\Brand::all() as $key => $brand)
                                <option value="{{ $brand->id }}">{{ $brand->getTranslation('name') }}</option>
                            @endforeach
                        </select>
                    </div> -->
                </div>
                <div class="aiz-pos-product-list c-scrollbar-light">
                    <div class="d-flex flex-wrap justify-content-center" id="product-list">

                    </div>
                    {{-- <div id="load-more" class="text-center">
                        <div class="fs-14 d-inline-block fw-600 btn btn-soft-primary c-pointer" onclick="loadMoreProduct()">{{ translate('Loading..') }}</div>
                    </div> --}}
                </div>
            </div>
            <div class="col-md-auto w-md-350px w-lg-400px w-xl-500px">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex border-bottom pb-3">
                            <div class="flex-grow-1">
                                <select name="user_id" class="form-control aiz-selectpicker pos-customer" data-live-search="true" onchange="getShippingAddress()">
                                    <option value="">{{translate('Walk In Customer')}}</option>
                                    @foreach (\App\Customer::all() as $key => $customer)
                                        @if ($customer->user)
                                            <option value="{{ $customer->user->id }}" data-contact="{{ $customer->user->email }}">{{ $customer->user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" class="btn btn-icon btn-soft-dark ml-3 mr-0" data-target="#new-customer" data-toggle="modal">
								<i class="las la-truck"></i>
							</button>
                        </div>
                    
                        <div class="" id="cart-details">
                            <!-- <div class="aiz-pos-cart-list mb-4 mt-3 c-scrollbar-light">
                                @php
                                    $subtotal = 0;
                                    $tax = 0;
                                @endphp
                                @if (Session::has('pos.cart'))
                                    <ul class="list-group list-group-flush">
                                    @forelse (Session::get('pos.cart') as $key => $cartItem)
                                        @php
                                            $subtotal += $cartItem['price']*$cartItem['quantity'];
                                            $tax += $cartItem['tax']*$cartItem['quantity'];
                                            $stock = \App\ProductStock::find($cartItem['stock_id']);
                                        @endphp
                                        <li class="list-group-item py-0 pl-2">
                                            <div class="row gutters-5 align-items-center">
                                                <div class="col-auto w-60px">
                                                    <div class="row no-gutters align-items-center flex-column aiz-plus-minus">
                                                        <button class="btn col-auto btn-icon btn-sm fs-15" type="button" data-type="plus" data-field="qty-{{ $key }}">
                                                            <i class="las la-plus"></i>
                                                        </button>
                                                        <input type="text" name="qty-{{ $key }}" id="qty-{{ $key }}" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="{{ $cartItem['quantity'] }}" min="{{ $stock->product->min_qty }}" max="{{ $stock->qty }}" onchange="updateQuantity({{ $key }})">
                                                        <button class="btn col-auto btn-icon btn-sm fs-15" type="button" data-type="minus" data-field="qty-{{ $key }}">
                                                            <i class="las la-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="text-truncate-2">{{ $stock->product->name }}</div>
                                                    <span class="span badge badge-inline fs-12 badge-soft-secondary">{{ $cartItem['variant'] }}</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="fs-12 opacity-60">{{ single_price($cartItem['price']) }} x {{ $cartItem['quantity'] }}</div>
                                                    <div class="fs-15 fw-600">{{ single_price($cartItem['price']*$cartItem['quantity']) }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="button" class="btn btn-circle btn-icon btn-sm btn-soft-danger ml-2 mr-0" onclick="removeFromCart({{ $key }})">
                                                        <i class="las la-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="list-group-item">
                                            <div class="text-center">
                                                <i class="las la-frown la-3x opacity-50"></i>
                                                <p>{{ translate('No Product Added') }}</p>
                                            </div>
                                        </li>
                                    @endforelse
                                    </ul>
                                @else
                                    <div class="text-center">
                                        <i class="las la-frown la-3x opacity-50"></i>
                                        <p>{{ translate('No Product Added') }}</p>
                                    </div>
                                @endif
                            </div> -->
                            <div>
                                <div class="d-flex justify-content-between fw-600 mb-2 opacity-70">
                                    <span>{{translate('Sub Total')}}</span>
                                    <span>{{single_price($subtotal) }}</span>
                                </div>
                                <div class="d-flex justify-content-between fw-600 mb-2 opacity-70">
                                    <span>{{translate('Tax')}}</span>
                                    <span>{{ single_price($tax) }}</span>
                                </div>
                                <div class="d-flex justify-content-between fw-600 mb-2 opacity-70">
                                    <span>{{translate('Shipping')}}</span>
                                    <span>{{ single_price(Session::get('pos.shipping', 0)) }}</span>
                                </div>
                                <div class="d-flex justify-content-between fw-600 mb-2 opacity-70">
                                    <span>{{translate('Discount')}}</span>
                                    <span>{{ single_price(Session::get('pos.discount', 0)) }}</span>
                                </div>
                                <div class="d-flex justify-content-between fw-600 fs-18 border-top pt-2">
                                    <span>{{translate('Total')}}</span>
                                    <span>{{ single_price($subtotal+$tax+Session::get('pos.shipping', 0) - Session::get('pos.discount', 0)) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pos-footer mar-btm">
                    <div class="d-flex flex-column flex-md-row justify-content-between">
                        <div class="d-flex">
                            <div class="dropdown mr-3 ml-0 dropup">
                                <button class="btn btn-outline-dark btn-styled dropdown-toggle" type="button" data-toggle="dropdown">
                                    {{translate('Shipping')}}
                                </button>
                                <div class="dropdown-menu p-3 dropdown-menu-lg">
                                    <div class="input-group">
                                        <input type="number" min="0" placeholder="Amount" name="shipping" class="form-control" value="{{ Session::get('pos.shipping', 0) }}" required onchange="setShipping()">
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ translate('Flat') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown dropup">
                                <button class="btn btn-outline-dark btn-styled dropdown-toggle" type="button" data-toggle="dropdown">
                                    {{translate('Discount')}}
                                </button>
                                <div class="dropdown-menu p-3 dropdown-menu-lg">
                                    <div class="input-group">
                                        <input type="number" min="0" placeholder="Amount" name="discount" class="form-control" value="{{ Session::get('pos.discount', 0) }}" required onchange="setDiscount()">
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ translate('Flat') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-2 my-md-0">
                            <button type="button" class="btn btn-primary btn-block" onclick="orderConfirmation()">{{ translate('Place Order') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row mt-3" style="border-top: 3px solid #ac8bce" >
        <div class="col-md-4 col-sm-6 mt-3">
                <div class="form-group">
                    <label for="exampleFormControlInput1"><b>Sale Date</b></label>
                    <input type="date" class="form-control" id="todays-date">
                </div>      
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="form-group mt-3">
                <label for="exampleFormControlSelect1"><b>Discount Type:*</b></label>
                <select class="form-control" id="exampleFormControlSelect1">
                  <option>Please Select</option>
                  <option>Fixed</option>
                  <option value="percentage" selected="selected">Percentage</option>

                </select>
              </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="input-group mb-3 mt-5">
                <span><b>Discount Amount</b>:(-) 0.00</span>
              </div>
          </div>
    
      </div>


     <div class="row">
        <div class="col-md-4 col-sm-6">
        <div class="form-group mt-3">
                <label for="exampleFormControlInput1"><b>Order instruction</b></label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Order instruction">
              </div>
        </div>
        <div class="col-md-4 col-sm-6">
        <div class="form-group mt-3">
                <label for="exampleFormControlInput1"><b>Shipping Address</b></label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Shipping Address">
              </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="form-group mt-3">
                <label for="exampleFormControlInput1"><b>Shipping Status</b></label>
              <select class="form-control" id="shipping_status" name="shipping_status">
                    <option selected="selected" value="">Please Select</option>
                    <option value="processing">Processing</option>
                    <option value="pending">Pending</option>
                    <option value="shipped">Shipped</option>
                    <option value="on-hold">Hold</option>
                    <option value="refunded">Returned</option>
                    <option value="failed">Failed</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="completed">Completed</option>
                    <option value="trash">Deleted</option>
                    <option value="readytoship">Ready to ship</option>
                </select>
            </div>
        </div>
        </div>





        <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="form-group mt-3">
                <label for="exampleFormControlInput1"><b>Payment type:*</b></label>
                <select class="form-control valid" required="" id="payment_type" name="payment_type" aria-required="true" aria-invalid="false">
                    <option value="">Please Select</option>
                    <option value="cod" selected="selected">Cash on delivery</option>
                    <option value="full_paid">Full paid</option>
                    <option value="partial_paid">Partial paid</option>
                    <option value="other">Other</option>
                </select>
            </div>
  
        </div>
        <div class="col-md-4 col-sm-6">

        </div>
            <div class="col-md-4 col-sm-6 mt-3">
                <span>(Round Off: 0)</span><br>
                    <b>Total Payable</b>: 0.00
            </div>
            </div>
              <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group mt-3">
                        <label for="exampleFormControlInput1"><b>Sell note</b></label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                 </div>
                </div>
              </div>

              {{-- add payment --}}
              <div class="payment" style="border-top: 3px solid #ac8bce">
                  <h5 class="mt-2">Payment</h5>
                  <p class="mt-5"><b>Advance Balance</b>: ৳ 0.00</p>
                  <div class="row">
                      <div class="col-md-4">
                        <div class="form-group mt-3">
                            <label for="exampleFormControlInput1"><b>Amount:*</b></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="0.00">
                     </div>
  
                      </div>
                      <div class="col-md-4">
                        <div class="form-group mt-3">
                            <label for="exampleFormControlInput1"><b>Payment Method:*</b></label>
                            <select class="form-control valid" required="" id="select-state" name="select-state" aria-required="true" aria-invalid="false" placeholder="search here">
                                <option value="">Cash</option>
                                <option value="cod">Card</option>
                                <option value="full_paid">Cheque</option>
                                <option value="partial_paid">Bank Transfer</option>
                                <option value="">Other</option>
                                <option value="">Custom Payment 1</option>
                            </select>
                     </div>

                      </div>

                      <div class="col-md-4">


                      </div>
                  </div>
                  <div class="row" style="border-bottom: 1px solid black">
   
                  </div>
        <p style="float: right" class="mt-3"><b>Balance</b></span>
            <span>{{ single_price($subtotal+$tax+Session::get('pos.shipping', 0) - Session::get('pos.discount', 0)) }}</span>
        
        </p><br><br>
                  <span style="float: right" class="mt-5">
                    <input class="btn btn-primary" type="button" value="Save">
                    <input class="btn btn-primary" type="button" value="Save and Print">
                </span>
                
              </div>
            
        </div>
      </div>
</section>

@endsection

@section('modal')
    <!-- Address Modal -->
    <div id="new-customer" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header bord-btm">
                    <h4 class="modal-title h6">{{translate('Shipping Address')}}</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="shipping_form">
                    <div class="modal-body" id="shipping_address">


                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-styled btn-base-3" data-dismiss="modal" id="close-button">{{translate('Close')}}</button>
                    <button type="button" class="btn btn-primary btn-styled btn-base-1" id="confirm-address" data-dismiss="modal">{{translate('Confirm')}}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- new address modal -->
    <div id="new-address-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header bord-btm">
                    <h4 class="modal-title h6">{{translate('Shipping Address')}}</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form class="form-horizontal" action="{{ route('addresses.store') }}" method="POST" enctype="multipart/form-data">
                	@csrf
                    <div class="modal-body">
                        <input type="hidden" name="customer_id" id="set_customer_id" value="">
                        <div class="form-group">
                            <div class=" row">
                                <label class="col-sm-2 control-label" for="address">{{translate('Address')}}</label>
                                <div class="col-sm-10">
                                    <textarea placeholder="{{translate('Address')}}" id="address" name="address" class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class=" row">
                                <label class="col-sm-2 control-label" for="email">{{translate('Country')}}</label>
                                <div class="col-sm-10">
                                    <select name="country" id="country" class="form-control aiz-selectpicker" required data-placeholder="{{translate('Select country')}}">
                                        @foreach (\App\Country::where('status',1)->get() as $key => $country)
                                            <option value="{{ $country->name }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class=" row">
                                <label class="col-sm-2 control-label" for="city">{{translate('City')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="{{translate('City')}}" id="city" name="city" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class=" row">
                                <label class="col-sm-2 control-label" for="postal_code">{{translate('Postal code')}}</label>
                                <div class="col-sm-10">
                                    <input type="number" min="0" placeholder="{{translate('Postal code')}}" id="postal_code" name="postal_code" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class=" row">
                                <label class="col-sm-2 control-label" for="phone">{{translate('Phone')}}</label>
                                <div class="col-sm-10">
                                    <input type="number" min="0" placeholder="{{translate('Phone')}}" id="phone" name="phone" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-styled btn-base-3" data-dismiss="modal">{{translate('Close')}}</button>
                        <button type="submit" class="btn btn-primary btn-styled btn-base-1">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="order-confirm" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom modal-xl">
            <div class="modal-content" id="variants">
                <div class="modal-header bord-btm">
                    <h4 class="modal-title h6">{{translate('Order Summary')}}</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="order-confirmation">
                    <div class="p-4 text-center">
                        <i class="las la-spinner la-spin la-3x"></i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-styled btn-base-3" data-dismiss="modal">{{translate('Close')}}</button>
                    <button type="button" onclick="submitOrder('cash')" class="btn btn-styled btn-base-1 btn-primary">{{translate('Comfirm Order')}}</button>
                </div>
            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection


@section('script')
    <script type="text/javascript">

        var products = null;

        $(document).ready(function(){
            $('body').addClass('side-menu-closed');
            $('#product-list').on('click','.add-plus:not(.c-not-allowed)',function(){
                var stock_id = $(this).data('stock-id');
                $.post('{{ route('pos.addToCart') }}',{_token:AIZ.data.csrf, stock_id:stock_id}, function(data){
                    if(data.success == 1){
                        updateCart(data.view);
                    }else{
                        AIZ.plugins.notify('danger', data.message);
                    }
                    
                });
            });
            filterProducts();
            getShippingAddress();
        });
        
        $("#confirm-address").click(function (){
            var data = new FormData($('#shipping_form')[0]);
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': AIZ.data.csrf
                },
                method: "POST",
                url: "{{route('pos.set-shipping-address')}}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data, textStatus, jqXHR) {
                }
            })
        });

        function updateCart(data){
            $('#cart-details').html(data);
            AIZ.extra.plusMinus();
        }

        function filterProducts(){
            var keyword = $('input[name=keyword]').val();
             var category = $('select[name=poscategory]').val();
             var brand = $('select[name=brand]').val();
            $.get('{{ route('pos.search_product') }}',{keyword:keyword,category:category,brand:brand}, function(data){
                products = data;
                $('#product-list').html(null);
                setProductList(data);
            });
        }

        function loadMoreProduct(){
            if(products != null && products.links.next != null){
                $('#load-more').find('.btn').html('{{ translate('Loading..') }}');
                $.get(products.links.next,{}, function(data){
                    products = data;
                    setProductList(data);
                });
            }
        }

        function setProductList(data){
            for (var i = 0; i < data.data.length; i++) {
                $('#product-list').append(
                    `<div class="w-140px w-xl-180px w-xxl-210px mx-2">
                        <div class="card bg-white c-pointer product-card hov-container">
                            <div class="position-relative">
                                 
                                ${data.data[i].variant != null
                                    ? `<span class="badge badge-inline badge-warning absolute-bottom-left mb-1 ml-1 mr-0 fs-13 text-truncate">${data.data[i].variant}</span>`
                                    : '' }
                                <img src="${data.data[i].thumbnail_image }" class="card-img-top img-fit h-120px h-xl-180px h-xxl-210px mw-100 mx-auto" >
                            </div>
                            <div class="card-body p-2 p-xl-3">
                                <div class="text-truncate fw-600 fs-14 mb-2">${data.data[i].name}</div>
                                <div class="">
                                    ${data.data[i].price != data.data[i].base_price
                                        ? `<del class="mr-2 ml-0">${data.data[i].base_price}</del><span>${data.data[i].price}</span>`
                                        : `<span>${data.data[i].base_price}</span>`
                                    }
                                </div>
                            </div>
                            <div class="add-plus absolute-full rounded overflow-hidden hov-box ${data.data[i].qty <= 0 ? 'c-not-allowed' : '' }" data-stock-id="${data.data[i].stock_id}">
                                <div class="absolute-full bg-dark opacity-50">
                                </div>
                                <i class="las la-plus absolute-center la-6x text-white"></i>
                            </div>
                        </div>
                    </div>`
                );
            }
            if (data.links.next != null) {
                $('#load-more').find('.btn').html('{{ translate('Load More.') }}');
            }
            else {
                $('#load-more').find('.btn').html('{{ translate('Nothing more found.') }}');
            }
        }

        function removeFromCart(key){
            $.post('{{ route('pos.removeFromCart') }}', {_token:AIZ.data.csrf, key:key}, function(data){
                updateCart(data);
            });
        }

        function addToCart(product_id, variant, quantity){
            $.post('{{ route('pos.addToCart') }}',{_token:AIZ.data.csrf, product_id:product_id, variant:variant, quantity, quantity}, function(data){
                $('#cart-details').html(data);
                $('#product-variation').modal('hide');
            });
        }

        function updateQuantity(key){
            $.post('{{ route('pos.updateQuantity') }}',{_token:AIZ.data.csrf, key:key, quantity: $('#qty-'+key).val()}, function(data){
                if(data.success == 1){
                    updateCart(data.view);
                }else{
                    AIZ.plugins.notify('danger', data.message);
                }
            });
        }

        function setDiscount(){
            var discount = $('input[name=discount]').val();
            $.post('{{ route('pos.setDiscount') }}',{_token:AIZ.data.csrf, discount:discount}, function(data){
                updateCart(data);
            });
        }

        function setShipping(){
            var shipping = $('input[name=shipping]').val();
            $.post('{{ route('pos.setShipping') }}',{_token:AIZ.data.csrf, shipping:shipping}, function(data){
                updateCart(data);
            });
        }

        function getShippingAddress(){
            $.post('{{ route('pos.getShippingAddress') }}',{_token:AIZ.data.csrf, id:$('select[name=user_id]').val()}, function(data){
                $('#shipping_address').html(data);
            });
        }

        function add_new_address(){
             var customer_id = $('#customer_id').val();
            $('#set_customer_id').val(customer_id);
            $('#new-address-modal').modal('show');
            $("#close-button").click();
        }

        function orderConfirmation(){
            $('#order-confirmation').html(`<div class="p-4 text-center"><i class="las la-spinner la-spin la-3x"></i></div>`);
            $('#order-confirm').modal('show');
            $.post('{{ route('pos.getOrderSummary') }}',{_token:AIZ.data.csrf}, function(data){
                $('#order-confirmation').html(data);
            });
        }
        function submitOrder(payment_type){
            var user_id = $('select[name=user_id]').val();
            var name = $('input[name=name]').val();
            var email = $('input[name=email]').val();
            var address = $('textarea[name=address]').val();
            var country = $('select[name=country]').val();
            var city = $('input[name=city]').val();
            var postal_code = $('input[name=postal_code]').val();
            var phone = $('input[name=phone]').val();
            var shipping = $('input[name=shipping]:checked').val();
            var discount = $('input[name=discount]').val();
            var shipping_address = $('input[name=address_id]:checked').val();
            
            $.post('{{ route('pos.order_place') }}',{
                _token              :   AIZ.data.csrf, 
                user_id             :   user_id, 
                name                :   name, 
                email               :   email, 
                address             :   address, 
                country             :   country, 
                city                :   city, 
                postal_code         :   postal_code, 
                phone               :   phone, 
                shipping_address    :   shipping_address, 
                payment_type        :   payment_type, 
                shipping            :   shipping, 
                discount            :   discount
            }, function(data){
                if(data.success == 1){
                    AIZ.plugins.notify('success', data.message );
                    location.reload();
                }
                else{
                    AIZ.plugins.notify('danger', data.message );
                }
            });
        }

        // get current date

        var today = new Date();
        var dd = ("0" + (today.getDate())).slice(-2);
        var mm = ("0" + (today.getMonth() +　1)).slice(-2);
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd ;
        $("#todays-date").attr("value", today)

   

        //search select option
        $(document).ready(function () {
         $('select').selectize({
          sortField: 'text'
           });
         });

  

    </script>
@endsection
