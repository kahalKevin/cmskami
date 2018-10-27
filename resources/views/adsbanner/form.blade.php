<div class="card">
    <div class="card-header">
        <strong class="card-title"><h3 class="text-center"></h3></strong>
    </div>
    <div class="card-body">
        <!-- Credit Card -->
        <div id="pay-invoice">
            <div class="card-body">
            @if(isset($adsbanners))
                {{ Form::open(array('url'=>'web-management/adsInventory/'.$adsInventory->id , 'method' => 'PATCH', 'enctype'=> 'multipart/form-data')) }}
            @else
                {{ Form::open(array('url'=>'web-management/adsInventory' , 'method'=>'POST' , 'enctype'=> 'multipart/form-data')) }}
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
                                <label for="_name" class="control-label mb-1">Image</label>
                                @if (isset($adsbanners))
                                <div class="row">
                                    <div class="col-6">
                                        <img src="{{ $adsbanners->_image_url }}">
                                    </div>
                                </div>
                                @endif
                                <input type="file" class="form-control" name="_upload_image"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_title" class="control-label mb-1">Title</label>
                                <input id="_title" name="_title" type="text" class="form-control" value="{{ isset($adsbanners) ? $adsbanners->_title : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_href_url" class="control-label mb-1">Href URL</label>
                                <input id="_href_url" name="_href_url" type="text" class="form-control" value="{{ isset($adsbanners) ? $adsbanners->_href_url : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_href_open_type" class="control-label mb-1">Href Open Type</label>
                                <select class="form-control" name="_href_open_type">
                                    <option>--Open Type--</option>
                                    <option value="_blank" {{ isset($adsbanners) ? ($adsbanners->_href_open_type == '_blank' ? 'selected' : '') : '' }}>Blank</option>
                                    <option value="_self" {{ isset($adsbanners) ? ($adsbanners->_href_open_type == '_self' ? 'selected' : '') : '' }}>Self</option>
                              </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_desc" class="control-label mb-1">Desc</label>
                                <textarea name="_desc" id="_desc" rows="9" placeholder="" class="form-control">{{ isset($adsbanners) ? $adsbanners->_desc : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success"><strong>{{ isset($adsbanners) ? 'Update' : 'Create' }}</strong></button>
                    </div>                
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>