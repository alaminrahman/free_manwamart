@extends('backend.layouts.app')

@section('content')


 <div class="container">

    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
       Save
      </button> --}}

      <div class="row">
          <div class="col-md-12">
            <div class="d-flex justify-content-end">

                <a class="btn btn-success" href="#" id="createNewProduct" data-toggle="modal" data-target="#exampleModal" style="float: right; margin-bottom: 1%;"> Add</a>

            </div>

            <div class="card">

                <div class="card-header">
                   <h4> Courier Service List</h4>
                </div>
                  <div class="card-body">

                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($courier as $item)
                        <tr>
                            <td>{{ Str::ucfirst($item->name) }}</td>
                            <td class="text-center">
                                <a href="{{ route('courier.delete', $item->id) }}"
                                    class="btn btn-danger btn-sm" id="delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                        </tbody>
                    </table>
                  </div>
              </div>



          </div><!--End col-->
      </div><!--End row-->





<!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Account</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="myform" action="{{route('courier.store')}}" method="post">
              <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                <div class="form-group">
                  <label for="formGroupExampleInput">Name</label>
                  <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Name">
                </div>
              </form>

        </div>
        <div class="modal-footer">
          <input type="submit" form="myform" class="btn btn-rounded btn-primary ml-3" value="Add New">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        </div>
      </div>
    </div>
  </div>


</div>



@endsection
