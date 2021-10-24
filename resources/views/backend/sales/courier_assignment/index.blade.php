Invoice No.@extends('backend.layouts.app')

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
                                    <th>Total Parcel</th>
                                    <th>Created By</th>
                                    <th>Additional Note</th>
                                    <th>Action </th>
                                </tr>
                            </thead>

                            <tbody id="myTable">
                                @forelse($courier_assigned as $key => $item)
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                    <td>{{ $item->pay_ref_number }}</td>
                                    <td>{{ Str::ucfirst($item->courier_id) }}</td>
                                    <td>{{ $item->total_item }}</td>
                                    <td>{{ $item->total_cost }}</td>
                                    <td>{{ $item->total_parcel }}</td>
                                    <td>{{ $item->create_by->name }}</td>
                                    <td>
                                        @if($item->additional_note != NULL)
                                            {{ $item->additional_note }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo<?= $key; ?>" aria-expanded="false" aria-controls="collapseTwo<?= $key; ?>">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                        </h5>

                                    </td>
                                </tr>

                                {{-- Start Toggle --}}
                                <tr>
                                    <td colspan="9">

                                        <div id="accordion<?= $key; ?>">
                                            <div id="collapseTwo<?= $key; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion<?= $key; ?>">
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
                                                        @foreach($item->courier_assigned_product as $key => $product)

                                                        @php
                                                            $customer = \App\User::where('id', $product->customer_id)->first();
                                                        @endphp

                                                            <tr>
                                                                <th scope="row">{{ $product->invoice_no }}</th>
                                                                <td>{{ $customer->name }}</td>
                                                                <td>
                                                                    @if($customer->address != NULL)
                                                                        {{ $customer->address }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>{{ $customer->phone }}</td>
                                                                <td>{{ $product->cost }}</td>
                                                                <td>{{ $product->item }}</td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                {{-- End Toggle --}}
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No Data Found!</td>
                                    </tr>

                                @endforelse
                            </tbody>
                        </table>



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

