@extends('backend.layouts.app')

<style>
    .list-group-item{
        margin-left: 7%;
    }
    .list-group-item:hover{
        background-color: #92a8d1;;
    }

</style>

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h3>Assign courier</h3>
                </div>

                <div class="card-body">

                    <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">


                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleFormControlInput1"><b>Date:*</b></label>
                                <input type="date" class="form-control" id="todays-date">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlInput1"><b>Reference No:</b></label>
                                <input type="text" class="form-control" name="">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlInput1"><b>Courier:*</b></label>
                                <select class="form-control valid" required="" name="courier" id="courier" aria-required="true" aria-invalid="false">
                                    <option selected="selected">Please Select</option>
                                        @foreach ($courier as $item)
                                        <option value="{{ $item->name }}">{{ Str::ucfirst($item->name) }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-3">

                        </div>
                    </div>

                </div><!--End body-->

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <h5>Search Products</h5>
                        </div>

                    </div><!--End Row-->

                    <div class="row">

                        <div class="col-md-8 offset-md-2 my-3">
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroup-sizing-default"><i class="fa fa-search" aria-hidden="true"></i></span>
                                </div>
                                <input type="text"  name="order" id="order" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="search Order" autocomplete="off">
                              </div>

                              <div id="order_list">

                              </div>
                        </div>
                    </div><!--End Row-->


                    <div class="row">
                        <div class="col-md-12">

                            <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col">Invoice No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Weight</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Zone</th>
                                    <th scope="col">Area</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Total Items</th>
                                  </tr>
                                </thead>
                                <tbody id="show">

                                </tbody>

                              </table>

                              <div id="additional">


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="additional_note"><b>Additional Notes</b></label>
                                        <textarea class="form-control" name="additional_note" id="additional_note" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-4">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <p>Total Amount: TK. <span style="margin-left: 2.6rem;" id="price">0</span></p>
                                            <input type="hidden" name="total_cost" value="">
                                        </div>

                                        <div class="col-md-12">
                                            <p>Total parcel:<span style="margin-left: 3.3rem;">0</span></p>
                                            <input type="hidden" name="total_parcel" value="">
                                        </div>

                                        <div class="col-md-12">
                                            <p>Total items:<span style="margin-left: 3.6rem;">0</span></p>
                                            <input type="hidden" name="total_item" value="">
                                        </div>
                                    </div>
                                </div>

                            </div><!--End Row -->

                              </div><!--End Additional-->

                            <input type="submit" form="myform" style="float: right" class="btn btn-rounded btn-primary ml-3" value="Save">



                        </div><!--End Col-->
                    </div><!--End Row-->

                </div><!--End Card body-->
            </div><!--End Card-->


        </div><!--End Col-->
    </div><!--End Row-->
</div><!--End Container-->


@endsection

@section('script')

<script>
      // get current date

      var today = new Date();
        var dd = ("0" + (today.getDate())).slice(-2);
        var mm = ("0" + (today.getMonth() +　1)).slice(-2);
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd ;
        $("#todays-date").attr("value", today)

</script>




<script type="text/javascript">
    $(document).ready(function () {

        $('#order').on('keyup',function() {
            var query = $(this).val();
            $.ajax({

                url:"{{ route('search.order') }}",
                type:"GET",
                data:{'order':query},
                success:function (data) {
                    $('#order_list').html(data);

                    console.log(data)
                }
            })
            // end of ajax call
        });

        $('#order_list').html('<li></li>');

    });


    function getOrder(order_id){
        var courier_name = $('#courier').val();
        var unique_num = 1;

        $.ajax({
            url:'{{ route("getOrder") }}',
            data:{
                order_id: order_id,
                courier_name:courier_name,
                unique_num: unique_num,
            },
            success:function(data){
                $('#show').append(data);
                console.log('Data Found!')
            },
            error:function(){
                console.log('Data not Found!')
            }
        })
    }

    function getPrice(){
        var recipient_city = $('#city_id').val();
        var recipient_zone = $('#zone_id').val();
        var weight = $('#weight').val();

        $.ajax({
            url:'{{ route("getPrice") }}',
            data:{
                recipient_city: recipient_city,
                recipient_zone:recipient_zone,
                weight:weight,
            },
            success:function(data){
                let one = 0;
                one += 1;

                $('#single_price'+one+'').text(data.data.price);
                $('[name=single_price]').val(data.data.price);
                console.log('Price Found!')
            },
            error:function(){
                console.log('Data not Found!')
            }
        })

    }

    // $(document).ready(function () {

    //     $('#zone_id').on('change', function(){
    //         var zone_id = $(this).val();
    //         var city_id = $('#city_id').val();

    //         alert(city_id);
    //     })

    // });

</script>
@endsection
