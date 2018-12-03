<div class="card">
    <div class="card-header">
        <strong class="card-title"><h3 class="text-center">Player Form</h3></strong>
    </div>
    <div class="card-body">
        <!-- Credit Card -->
        <div id="pay-invoice">
            <div class="card-body">
            @if(isset($players))
                {{ Form::open(array('url'=>'master-data/players/'.$players->id , 'method' => 'PATCH')) }}
            @else
                {{ Form::open(array('url'=>'master-data/players' , 'method'=>'POST' )) }}
            @endif            
                    @if ($errors->any())
                        <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                    @endif
                    @if (\Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ \Session::get('success') }}</p>
                        </div>
                    @endif
                    @if(isset($players))
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="league_id" class="control-label mb-1">League</label>
                                <select class="form-control" name="league_id">
                                    <option>--League--</option>
                                @foreach($leagues as $league)
                                    <option value="{{ $league->id }}" {{ $league_id == $league->id? 'selected' : '' }}>{{ $league->_name }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="club_id" class="control-label mb-1">Club</label>
                                <select class="form-control" name="club_id">
                                <option value="">--- Club ---</option>
                                @if($clubs)
                                    @foreach($clubs as $club)
                                      <option value="{{ $club->id }}" {{ $players->club_id == $club->id? 'selected' : '' }}>{{ $club->_name }}</option>
                                    @endforeach
                                @endif
                              </select>
                            </div>
                        </div>
                    </div>          
                    @else
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="league_id" class="control-label mb-1">League</label>
                                <select class="form-control" name="league_id">
                                    <option>--League--</option>
                                @foreach($leagues as $league)
                                    <option value="{{ $league->id }}">{{ $league->_name }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="club_id" class="control-label mb-1">Club</label>
                                <select class="form-control" name="club_id">
                                    <option>--Club--</option>
                                </select>
                                <p class="text-danger no-club-message d-none">No club in the league.</p>
                            </div>
                        </div>
                    </div>
                    @endif                    
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_name" class="control-label mb-1">Name</label>
                                <input id="_name" name="_name" type="text" class="form-control hashtag" value="{{ isset($players) ? $players->_name : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_number_shirt" class="control-label mb-1">Shirt Number</label>
                                <input id="_number_shirt" name="_number_shirt" type="text" class="form-control" value="{{ isset($players) ? $players->_number_shirt : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_active" class="control-label mb-1">Active?</label>
                                <select class="form-control" name="_active">
                                @if(isset($players))
                                    <option value="1" {{ $players->_active == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $players->_active == '0' ? 'selected' : '' }}>No</option>
                                @else
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                @endif
                                </select>
                            </div>
                        </div>
                    </div>                                         
                    <div>
                        <button type="submit" class="btn btn-success btn-submit"><strong>{{ isset($players) ? 'Update' : 'Create' }}</strong></button>
                    </div>                
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="league_id"]').on('change', function(){
            var league_id = $(this).val();
            if(league_id) {
                $.ajax({
                    url: '{{ url("/") }}/master-data/leagues/get-clubs/'+league_id,
                    type:"GET",
                    dataType:"json",
                    beforeSend: function(){
                        $('#loader').css("visibility", "visible");
                    },

                    success:function(data) {

                        $('select[name="club_id"]').empty();
                        
                        if (data.length > 0) {
                            $('.no-club-message').addClass('d-none');
                            $('.btn-submit').attr('disabled', false);
                            $.each(data, function(key, value){
                                $('select[name="club_id"]').append('<option value="'+ value.id +'">' + value._name + '</option>');
                            });   
                        } else {
                            $('.no-club-message').removeClass('d-none');
                            $('.btn-submit').attr('disabled', true);
                        }
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