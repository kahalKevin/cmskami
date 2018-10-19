@extends('layouts.admin_template')

        <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>    

@section('content')
<meta name="_token" content="{{ csrf_token() }}"/>
<div class="row">
  <div class="col-sm-12">
    <h2><strong>Manage Players</strong></h2>     
  </div>
</div>
<hr>
@if(Session::has('flash_message'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
@endif
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <strong>Filter</strong> Players
            </div>
            <div class="card-body card-block">
                {{ Form::open(array('url'=>'master-data/players' , 'method'=>'GET' )) }}
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="league" class=" form-control-label">League</label></div>
                        <div class="col-12 col-md-9">
                          <select class="form-control" name="league_id">
                                <option value="">--- League ---</option>
                            @foreach($leagues as $league)
                                <option value="{{ $league->id }}" {{ $request->league_id == $league->id? 'selected' : '' }}>{{ $league->_name }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="league" class=" form-control-label">Club</label></div>
                        <div class="col-12 col-md-9">
                              <select class="form-control" name="club_id">
                                <option value="">--- Club ---</option>
                                @if(isset($clubs))
                                @foreach($clubs as $club)
                                  <option value="{{ $club->id }}" {{ $request->club_id == $club->id? 'selected' : '' }}>{{ $club->_name }}</option>
                                @endforeach
                                @endif
                              </select>
                        </div>
                    </div>                                     
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="keyword" class=" form-control-label">Keyword</label></div>
                        <div class="col-12 col-md-9"><input id="" name="keyword" class="form-control" value="{{ $request->keyword ? $request->keyword : '' }}"></div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label for="status" class=" form-control-label">Active?</label></div>
                        <div class="col-12 col-md-9">
                          <select class="form-control" name="status">
                            <option value="" {{ !isset($request->status) ? 'selected' : '' }}>Please Select</option>
                            <option value="true" {{ $request->status == 'true' ? 'selected' : '' }}>Yes</option>
                            <option value="false" {{ $request->status == 'false' ? 'selected' : '' }}>No</option>
                          </select>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary"><strong>Submit</strong></button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div align="right" class="col-sm-12">
        <button type="button" class="btn btn-success" onclick="location.href='{{ url('master-data/players/create') }}'"><strong>Add New</strong></button>
    </div>
    <div class="col-sm-12">
        <div class="card">  
            <div class="card-header">
                <strong class="card-title">List </strong>Player
            </div>
            <div class="card-body">
              <table class="table table-bordered" id="table">
                 <thead>
                    <tr>
                      <th width="5%">ID</th>
                      <th>Name</th>
                      <th>League</th>
                      <th>Club</th>
                      <th>Shirt Number</th>                      
                      <th width="10%">Status</th>
                      <th width="30%"><center>Action</center></th>
                    </tr>
                 </thead>
              </table>
          <script>
           $(function() {
                var url_clean = "{{ url('master-data/players/load-data?keywordSearch='. $request->keyword . '&leagueId='. $request->league_id. '&clubId='. $request->club_id . '&status='. $request->status) }}"
                var fix_url = url_clean.replace(/&amp;/g, '&');
                 $('#table').DataTable({
                 processing: true,
                 serverSide: true,
                 searching: false,
                 ajax: fix_url,
                 columns: [
                          { data: 'id', defaultContent: '' },
                          { data: '_name', name: '_name' },
                          { data: 'league_name', name: 'league_name' },
                          { data: 'club_name', name: 'club_name' },
                          { data: '_number_shirt', name: '_number_shirt' },
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
                                '<a href=players/' + row.id + '/edit class="btn btn-primary"role="button">View & Edit<a> ' +
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
    $(document).ready(function() {
        $('select[name="league_id"]').on('change', function(){
            var league_id = $(this).val();
            if(league_id) {
                $.ajax({
                    url: '/master-data/leagues/get-clubs/'+league_id,
                    type:"GET",
                    dataType:"json",
                    beforeSend: function(){
                        $('#loader').css("visibility", "visible");
                    },

                    success:function(data) {

                        $('select[name="club_id"]').empty();
                        $('select[name="club_id"]').append('<option value="">--- Club ---</option>');
                        $.each(data, function(key, value){

                            $('select[name="club_id"]').append('<option value="'+ key +'">' + value + '</option>');

                        });
                    },
                    complete: function(){
                        $('#loader').css("visibility", "hidden");
                    }
                });
            } else {
                $('select[name="club_id"]').empty();
            }

        });
    });
</script>
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
          url: 'players/' + id,
          success: function(result) {
             location.reload();
          }
        });
      }
  }
</script>
@endsection