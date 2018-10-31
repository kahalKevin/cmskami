@extends('layouts.admin_template')

        <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>    

@section('content')
<meta name="_token" content="{{ csrf_token() }}"/>
<div class="row">
  <div class="col-sm-12">
    <h2><strong>Manage Stock Product - <a href="/category-product/product/{{$product->id}}/edit"><strong>{{$product->_name}}</a></strong></h2>     
  </div>
</div>
<hr>
@if(Session::has('flash_message'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
@endif
<div class="row">
    <div align="right" class="col-sm-12">
    <a href="/category-product/product/{{$product->id}}/edit"" class="btn btn-lg btn-success"><strong>Detail Product 
    </strong></a>    
    </div>
</div>
<div class="card col-sm-6">
    <div class="card-header">
        <strong class="card-title">Create New </strong>Stock
    </div>
    <div class="card-body">
        <!-- Credit Card -->
        <div id="pay-invoice">
            <div class="card-body">
                {{ Form::open(array('url'=>'category-product/product-stock' , 'method' => 'POST')) }}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                    @endif
                    <input name="product_id" type="hidden" value="{{$product->id}}">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="size_id" class="control-label mb-1">Size</label>
                                <select class="form-control" name="size_id">
                                @foreach($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->_name }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_available" class="control-label mb-1">Available?</label>
                                <select class="form-control" name="_available">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>                      
                    <div>
                        <button type="submit" class="btn btn-success"><strong>Add</strong></button>
                    </div>                
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">  
            <div class="card-header">
                <strong class="card-title">List </strong>Stock
            </div>
            <div class="card-body">
              <table class="table table-bordered" id="table">
                 <thead>
                    <tr>
                      <th width="5%">ID</th>
                      <th>Size</th>
                      <th>Status</th>
                      <th width="30%"><center>Action</center></th>
                    </tr>
                 </thead>
              </table>
          <script>
           $(function() {
                 $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                 searching: false,
                 ajax: "{{ url('category-product/product-stock/load-data?product_id='. $request->product_id) }}",
                 columns: [
                          { data: 'id', defaultContent: '' },
                          { data: 'size_name', name: 'size_name' },
                          {
                              mRender: function (data, type, row) {
                              if (row._available == '1') {
                                    return '<i class="fa fa-check-square"></i> Available'
                                } else {
                                    return '<i class="fa fa-square-o"></i> Not available'
                                }
                              }                            
                          },
                          {
                            mRender: function (data, type, row) {
                                return '<center>' +
                                '<a href="javascript:checkDelete('+ row.id +');" class="btn btn-danger"role="button">Delete<a> ' +
                                '</center>'
                            }
                          }                   
                       ]
              });
           });
          </script>
          </div>        
        </div>
    </div>    
</div>
<script type="text/javascript">
  function checkDelete(id) {
    if (confirm('Really Delete?')) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
          type: "DELETE",
          url: 'product-stock/' + id,
          success: function(result) {
             location.reload();
          }
        });
      }
  }
</script>
@endsection