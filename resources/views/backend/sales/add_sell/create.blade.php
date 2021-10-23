@extends('backend.layouts.app')

@section('content')

<section class="">

     <div class="row">

          <div class="col-md-12">
               <div class="row">
                    <div class="col-md-8">

                        <div class="card">
                            <div class="card-header">
                                <h3>Product</h3>
                            </div>

                            <div class="card-body">

                                <div class="row">
                                    <div class="col">
                                        <form action="" method="post">
                                            @csrf
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="product-keyword" placeholder="Search Product" aria-describedby="product-search">
                                                <button class="btn btn-outline-secondary" type="button" id="product-search">Search</button>
                                            </div>

                                            <div class="search-result mb-3" id="search-result" >
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <div class="product d-flex align-items-center">
                                                            <div class="img mr-2"><img src="{{ asset('public/assets/img/placeholder.jpg') }}" width="30" alt="Product Image"></div>

                                                            <div class="pro-nam"> An item</div>
                                                        </div><!--End product-->
                                                    </li>

                                                    <li class="list-group-item">
                                                        <div class="product d-flex align-items-center">
                                                            <div class="img mr-2"><img src="{{ asset('public/assets/img/placeholder.jpg') }}" width="30" alt="Product Image"></div>

                                                            <div class="pro-nam"> An item</div>
                                                        </div><!--End product-->
                                                    </li>

                                                  </ul>
                                            </div>

                                        </form>
                                    </div><!--End col-->
                                </div><!--End Row-->

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="product-result" id="product-result">
                                            <div class="card">
                                                <img src="{{ asset('public/assets/img/placeholder.jpg') }}" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <h6 class="card-title">Product Name</h6>

                                                  <p class="card-text">Price : TK. 1200</p>
                                                  <a href="#" class="btn btn-primary">Buy</a>
                                                </div>
                                              </div>
                                        </div><!--End product result-->
                                    </div><!--End col-->


                                </div><!--End Row-->

                            </div><!--End Card Body--->
                        </div><!--End Card--->

                    </div><!--End Col-->

                    <div class="col-md-4">

                         <div class="card mb-3">
                             <div class="card-header">
                                 <h3>Cart Details</h3>
                             </div>
                            <div class="card-body">


                                <div class="" id="cart-details">
                                    <!-- <div class="aiz-pos-cart-list mb-4 mt-3 c-scrollbar-light">
                                        @php
                                            $subtotal = 0;
                                            $tax = 0;
                                        @endphp

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
                    </div><!--End Col-->

               </div><!--End Row-->

          </div><!--End Col-->

     </div><!--End Row-->


     <div class="row">
         <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h3>Added Product</h3>
                </div>

                <div class="card-body">

                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col" class="text-center">Price</th>
                            <th scope="col" class="text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row" class="text-center">1</th>
                            <td class="text-center">555555</td>
                            <td>Potata</td>
                            <td class="text-center">1</td>
                            <td class="text-center">Tk. 10</td>
                            <td class="text-center">
                                <div class="btn btn-danger">Remove</div>
                            </td>
                          </tr>


                        </tbody>
                      </table>

                      <div class="button d-flex justify-content-between">
                          <button class="btn btn-info">Clear Cart</button>
                          <button class="btn btn-primary">Order Placed</button>
                      </div>


                </div><!--End card-body-->
            </div><!--End card-->



         </div><!--End Col-->
     </div><!--End Row-->


</section>

@endsection


@section('script')

    <script>
        $(document).ready(function(){

            $('#product-keyword').on('keyup', function(){
                var keyword = $(this).val();

                $.ajax({
                    url:'{{ route("getProduct") }}',
                    data:{
                        keyword: keyword,
                    },
                    success:function(response){
                        console.log('Product Found')
                    },
                    error:function(){
                        console.log('Product Not Found')
                    }
                });//End Ajax
            });


        });
    </script>

@endsection
