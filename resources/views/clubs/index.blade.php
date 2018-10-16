@extends('layouts.admin_template')

        <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>    

@section('content')
<meta name="_token" content="{{ csrf_token() }}"/>
<div class="row">
  <div class="col-sm-12">
    <h2><strong>Manage Club</strong></h2>     
  </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <strong>Filter</strong> Club
            </div>
            <div class="card-body card-block">
                {{ Form::open(array('url'=>'master-data/clubs' , 'method'=>'GET' )) }}
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="league" class=" form-control-label">League</label></div>
                        <div class="col-12 col-md-9">
                          <select class="form-control" name="league">
                            @foreach($leagues as $league)
                            <option value="{{ $league->id }}" {{ $request->league == $league->id? 'selected' : '' }}>{{ $league->_name }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="keyword" class=" form-control-label">Keyword</label></div>
                        <div class="col-12 col-md-9"><input id="" name="keyword" class="form-control" value="{{ $request->keyword ? $request->keyword : '' }}"></div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="status" class=" form-control-label">Active?</label></div>
                        <div class="col-12 col-md-9"><input id="status" name="status" class="form-control"></div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary"><strong>Submit</strong></button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div align="right" class="col-sm-12">
        <button type="button" class="btn btn-success" onclick="location.href='{{ url('master-data/clubs/create') }}'"><strong>Add New</strong></button>
    </div>
    <div class="col-sm-12">
        <div class="card">  
            <div class="card-header">
                <strong class="card-title">List </strong>User
            </div>
            <div class="card-body">
              <table class="table table-bordered" id="table">
                 <thead>
                    <tr>
                      <th width="5%">ID</th>
                      <th>Name</th>
                      <th>League</th>
                      <th>Desc</th>
                      <th width="10%">Status</th>
                      <th width="30%"><center>Action</center></th>
                    </tr>
                 </thead>
              </table>
          <script>
           $(function() {
                var url_clean = "{{ url('master-data/clubs/load-data?keywordSearch='. $request->keyword . '&leagueId='. $request->league) }}"
                var fix_url = url_clean.replace(/&amp;/g, '&');
                 $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                 searching: false,
                 // ajax:{
                 //    url: "{{ url('master-data/users/load-data?keywordSearch='. $request->keyword) }}",
                 //    type: "GET",
                 //    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                 // },
                 ajax: fix_url,
                 columns: [
                          { data: 'id', defaultContent: '' },
                          { data: '_name', name: '_name' },
                          { data: 'league_name', name: 'league_name' },
                          { data: '_desc', name: '_desc' },
                          { data: '_active', name: '_active' },
                          {
                            mRender: function (data, type, row) {
                                return '<center>' +
                                '<a href=users/' + row.id + '/edit class="btn btn-primary"role="button">View & Edit<a> ' +
                                '<a href="javascript:checkDelete('+ row.id +');" class="btn btn-danger"role="button">Delete<a> ' +
                                '<a href="javascript:checkResetPassword('+ row.id +');" class="btn btn-warning"role="button">Reset Password<a></center>'
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
          url: 'users/' + id,
          success: function(result) {
             location.reload();
          }
        });
      }
  }
</script>
@endsection