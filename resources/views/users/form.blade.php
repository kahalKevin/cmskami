<div class="card">
    <div class="card-header">
        <strong class="card-title"><h3 class="text-center">User Form</h3></strong>
    </div>
    <div class="card-body">
        <!-- Credit Card -->
        <div id="pay-invoice">
            <div class="card-body">
            @if(isset($users))
                {{ Form::open(array('url'=>'master-data/users/'.$users->id , 'method' => 'PATCH')) }}
            @else
                {{ Form::open(array('url'=>'master-data/users' , 'method'=>'POST' )) }}
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
                                <label for="_email" class="control-label mb-1">Email</label>
                                <input id="_email" name="_email" type="text" class="form-control" value="{{ isset($users) ? $users->_email : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_password" class="control-label mb-1">Password</label>
                                <input id="_password" name="_password" type="password" class="form-control" value="{{ isset($users) ? $users->_password : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_fullname" class="control-label mb-1">Fullname</label>
                                <input id="_fullname" name="_fullname" type="text" class="form-control" value="{{ isset($users) ? $users->_full_name : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_phone" class="control-label mb-1">Phone</label>
                                <input id="_phone" name="_phone" type="tel" class="form-control" value="{{ isset($users) ? $users->_phone : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success"><strong>{{ isset($users) ? 'Update' : 'Create' }}</strong></button>
                    </div>                
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>