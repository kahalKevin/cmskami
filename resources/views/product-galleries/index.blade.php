@extends('layouts.admin_template')

        <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>    

@section('content')
<meta name="_token" content="{{ csrf_token() }}"/>
<div class="row">
  <div class="col-sm-12">
    <h2><strong>Manage Gallery Product - <a href="/category-product/product/{{$product->id}}/edit"><strong>{{$product->_name}}</a></strong></h2>     
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
        <strong class="card-title">Add New </strong>Gallery
    </div>
    <div class="card-body">
        <!-- Credit Card -->
        <div id="pay-invoice">
            <div class="card-body">
                {{ Form::open(array('url'=>'category-product/product-gallery' , 'method' => 'POST', 'files'=>'true')) }}
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
                        <div class="col-12">
                            <div class="form-group">
                                <label for="_upload_image" class="control-label mb-1">Image</label>
                            <input id="_upload_image" name="_upload_image" type="file" class="form-control">
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="_name" class="control-label mb-1">Name</label>
                                <input id="_name" name="_name" type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>                   
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="_desc" class="control-label mb-1">Desc</label>
                                <textarea name="_desc" id="_desc" rows="9" placeholder="" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="_active" class="control-label mb-1">Active?</label>
                                <select class="form-control" name="_active">
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
                      <th>Image</th>
                      <th>Name</th>
                      <th>Position</th>                                            
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
                 ajax: "{{ url('category-product/product-gallery/load-data?product_id='. $request->product_id) }}",
                 columns: [
                          { data: 'id', defaultContent: '' },
                          {
                              mRender: function (data, type, row) {
                              if (row._url != null && row._real_name != null) {
                                    return '<img src={{ url("/") }}' + row._url + '>'
                                } else {
                                    return '-'
                                }
                              }                            
                          },
                          { data: '_name', name: '_name' },
                          { data: '_position', name: '_position' },
                          {
                              mRender: function (data, type, row) {
                              if (row._active == '1') {
                                    return '<i class="fa fa-check-square"></i> Active'
                                } else {
                                    return '<i class="fa fa-square-o"></i> Not active'
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
<!-- <script type="text/javascript">
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
</script> -->
@endsection