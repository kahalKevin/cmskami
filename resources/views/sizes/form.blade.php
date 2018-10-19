<div class="card">
    <div class="card-header">
        <strong class="card-title"><h3 class="text-center">Size Form</h3></strong>
    </div>
    <div class="card-body">
        <!-- Credit Card -->
        <div id="pay-invoice">
            <div class="card-body">
            @if(isset($sizes))
                {{ Form::open(array('url'=>'master-data/sizes/'.$sizes->id , 'method' => 'PATCH')) }}
            @else
                {{ Form::open(array('url'=>'master-data/sizes' , 'method'=>'POST' )) }}
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
                                <label for="_name" class="control-label mb-1">Name</label>
                                <input id="_name" name="_name" type="text" class="form-control" value="{{ isset($sizes) ? $sizes->_name : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_desc" class="control-label mb-1">Desc</label>
                                <textarea name="_desc" id="_desc" rows="9" placeholder="" class="form-control">{{ isset($sizes) ? $sizes->_desc : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_active" class="control-label mb-1">Active?</label>
                                <select class="form-control" name="_active">
                                @if(isset($sizes))
                                    <option value="1" {{ $sizes->_active == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $sizes->_active == '0' ? 'selected' : '' }}>No</option>
                                @else
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                @endif
                                </select>
                            </div>
                        </div>
                    </div>                      
                    <div>
                        <button type="submit" class="btn btn-success"><strong>{{ isset($sizes) ? 'Update' : 'Create' }}</strong></button>
                    </div>                
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>