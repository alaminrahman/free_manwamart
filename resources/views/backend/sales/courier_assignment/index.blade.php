@extends('backend.layouts.app')

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
.table_color{
    background: gray;
}

</style>



@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="button d-flex justify-content-end my-3">
                <a href="{{route('courier.assignment_create')}}" type="button" style="float:right;" class="btn btn-primary btn-sm">Assign Courier</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Courier Assignment</h3>
                </div>

                <div class="card-body">

                    <div class="form-group">
                        <input id="myInput" type="text" class="form-control" placeholder="Search">
                    </div>

                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Pay reference number</th>
                                    <th>Courier</th>
                                    <th>Total Items</th>
                                    <th>Amount</th>
                                    <th>Created By</th>
                                    <th>Additional Note</th>
                                    <th>Action </th>
                                </tr>
                            </thead>

                            <tbody id="myTable">
                                <tr>
                                    <td>01-07-2021</td>
                                    <td>Doe</td>
                                    <td>Pathao</td>
                                    <td>3</td>
                                    <td>1250</td>
                                    <td>name</td>
                                    <td>Null</td>
                                    <td>
                                        <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                        </h5>

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div id="accordion">
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <table class="table table_color">
                                    <thead>
                                    <tr>
                                        <th scope="col">Invoice No</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Address	</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Total items</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">1234565</th>
                                        <td>Customer name</td>
                                        <td>Address</td>
                                        <td>01843736673</td>
                                        <td>1220</td>
                                        <td>2</td>

                                    </tr>
                                    <tr>
                                        <th scope="row">1234565</th>
                                        <td>Customer name</td>
                                        <td>Address</td>
                                        <td>01843736673</td>
                                        <td>1220</td>
                                        <td>2</td>
                                    </tr>


                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>

                </div><!--End Card Body-->


            </div><!--End Card-->

        </div><!--End Col-->
    </div><!--End Row-->
</div><!--End container-->



@endsection

@section('script')

<script>

    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });

</script>

@endsection

