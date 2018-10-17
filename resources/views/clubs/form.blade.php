<div class="card">
    <div class="card-header">
        <strong class="card-title"><h3 class="text-center">Club Form</h3></strong>
    </div>
    <div class="card-body">
        <!-- Credit Card -->
        <div id="pay-invoice">
            <div class="card-body">
            @if(isset($clubs))
                {{ Form::open(array('url'=>'master-data/clubs/'.$clubs->id , 'method' => 'PATCH')) }}
            @else
                {{ Form::open(array('url'=>'master-data/clubs' , 'method'=>'POST' )) }}
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
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="league_id" class="control-label mb-1">League</label>
                                <select class="form-control" name="league_id">
                                @foreach($leagues as $league)
                                <option value="{{ $league->id }}" {{ isset($clubs) && $clubs->league_id == $league->id ? 'selected' : '' }}>{{ $league->_name }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_name" class="control-label mb-1">Name</label>
                                <input id="_name" name="_name" type="text" class="form-control" value="{{ isset($clubs) ? $clubs->_name : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_desc" class="control-label mb-1">Desc</label>
                                <textarea name="_desc" id="_desc" rows="9" placeholder="" class="form-control">{{ isset($clubs) ? $clubs->_desc : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success"><strong>{{ isset($clubs) ? 'Update' : 'Create' }}</strong></button>
                    </div>                
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>