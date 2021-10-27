@extends('backend.layouts.app')

@section('content')

<form action="{{ route('add_sell_store') }}" method="POST">
    @csrf

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

                                                </div>

                                            </form>
                                        </div><!--End col-->
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
                                                        <th scope="col" style="width:50px !important;" class="text-center">ID</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col" style="width:50px !important;" class="text-center">QTY</th>
                                                        <th scope="col" class="text-center">Price</th>
                                                        <th scope="col" class="text-center">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody id="product_added">

                                                    </tbody>

                                                    </table>

                                                    <div class="button d-flex justify-content-between">
                                                        <a href="{{ route('clear_cart_item') }}" class="btn btn-info">Clear Cart</a>
                                                        <button type="submit" class="btn btn-primary">Order Placed</button>
                                                    </div>


                                            </div><!--End card-body-->
                                        </div><!--End card-->



                                        </div><!--End Col-->
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

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="payment_option">Payment Method</label>
                                            <select name="payment_option" class="form-control" required>
                                                <option value="">Select</option>
                                                <option value="admin_bkash">Bkash</option>
                                                <option value="admin_cash">Cash</option>
                                                <option value="admin_nogad">Nogad</option>
                                                <option value="admin_sslcommerze">SslCommerze</option>
                                            </select>
                                        </div>

                                        <div class="col-6">
                                            <label for="payment_status">Payment Status</label>
                                            <select name="payment_status" class="form-control" required>
                                                <option value="">Select</option>
                                                <option value="paid">Paid</option>
                                                <option value="unpaid">Unpaid</option>
                                            </select>
                                        </div>
                                    </div>


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
                                                TK. <span id="subtotal_show">0</span>
                                                <input type="hidden" id="subtotal" value="">
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
                                                Tk. <span id="total_show">0</span>
                                                <input  type="hidden" value="" id="total">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--End Col-->

                </div><!--End Row-->
            </div><!--End Col-->

        </div><!--End Row-->
    </section>
</form>

@endsection


@section('script')

    <script>
        $(document).ready(function(){

            $('#product-keyword').on('keyup', function(){
                var keyword = $(this).val();

                $.ajax({
                    url:'{{ route("getProductSearch") }}',
                    data:{
                        keyword: keyword,
                    },
                    success:function(response){
                        $('#search-result').html(response);
                        console.log('Product Found')
                    },
                    error:function(){
                        console.log('Product Not Found')
                    }
                });//End Ajax
            });


        });

        function addProductCart(product_id){
            var product_id = product_id;

            $.ajax({
                url:'{{ route("getProduct") }}',
                data:{
                    product_id:product_id,
                },
                success:function(response){
                    $('#product_added').append(response);
                    row_total_price();
                    clearSearchKeyword();
                    clearSearchResult();
                    console.log('Product Added !');
                },
                error:function(){
                    console.log('Product Not Added !');
                }
            });
        }

        function clearSearchResult(){
            $('#search-result').html('');
        }

        function clearSearchKeyword(){
            $('#product-keyword').val('');
        }

        function row_total_price(){
            var total = 0;
            $('.price').each(function(){
                total += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
            });

            $('#subtotal').val(total)
            $('#subtotal_show').text(total)

            $('#total_show').text(total);
            $('#total').val(total);


            console.log(total);
        }


    </script>

@endsection
