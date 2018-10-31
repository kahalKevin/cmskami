<div class="card">
    <div class="card-header">
        <strong class="card-title"><h3 class="text-center"></h3></strong>
    </div>
    <div class="card-body">
        <!-- Credit Card -->
        <div id="pay-invoice">
            <div class="card-body">
            @if(isset($policy))
                {{ Form::open(array('url'=>'web-management/aboutUs/'.$policy->id , 'method' => 'PATCH', 'enctype'=> 'multipart/form-data')) }}
            @else
                {{ Form::open(array('url'=>'web-management/aboutUs' , 'method'=>'POST' , 'enctype'=> 'multipart/form-data')) }}
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
                                <label for="_content" class="control-label mb-1">Content</label>
                                <textarea name="_content" id="_content" rows="9" placeholder="" class="form-control">{{ isset($policy) ? $policy->_content : '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="created_by" class="control-label mb-1">Last Edited</label>
                                <label for="created_by" class="control-label mb-1">{{ isset($policy) ? $policy->created_at : '' }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_desc" class="control-label mb-1">Edited By</label>
                                <label for="created_at" class="control-label mb-1">{{ isset($policy) ? $policy->_full_name : '' }}</label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-success"><strong>{{ isset($policy) ? 'Update' : 'Create' }}</strong></button>
                    </div>                
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>