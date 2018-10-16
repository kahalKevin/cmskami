@extends('layouts.admin_template')

        <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>    

@section('content')
<meta name="_token" content="{{ csrf_token() }}"/>
<div class="row">
  <div class="col-sm-12">
    <h2><strong>Manage Sleeve</strong></h2>     
  </div>
</div>
<hr>
<div class="row">
    <div align="right" class="col-sm-12">
        <button type="button" class="btn btn-success" onclick="location.href='{{ url('master-data/sleeves/create') }}'"><strong>Add New</strong></button>
    </div>
    <div class="col-sm-12">
        <div class="card">  
            <div class="card-header">
                <strong class="card-title">List </strong>Sleeve
            </div>
            <div class="card-body">
              <table class="table table-bordered" id="table">
                 <thead>
                    <tr>
                      <th width="5%">ID</th>
                      <th>Name</th>
                      <th>Desc</th>
                      <th width="10%">Status</th>
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
                 ajax: "{{ url('master-data/sleeves/load-data?keywordSearch='. $request->keyword) }}",
                 columns: [
                          { data: 'id', defaultContent: '' },
                          { data: '_name', name: '_name' },
                          { data: '_desc', name: '_desc' },
                          { data: '_active', name: '_active' },
                          {
                            mRender: function (data, type, row) {
                                return '<center>' +
                                '<a href=sleeves/' + row.id + '/edit class="btn btn-primary"role="button">View & Edit<a> ' +
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
          url: 'sleeves/' + id,
          success: function(result) {
             location.reload();
          }
        });
      }
  }
</script>
@endsection