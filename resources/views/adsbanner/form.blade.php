<div class="card">
    <div class="card-header">
        <strong class="card-title"><h3 class="text-center"></h3></strong>
    </div>
    <div class="card-body">
        <!-- Credit Card -->
        <div id="pay-invoice">
            <div class="card-body">
            @if(isset($adsbanners))
                {{ Form::open(array('url'=>'web-management/adsInventory/'.$adsbanners->id , 'method' => 'PATCH', 'enctype'=> 'multipart/form-data')) }}
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
                                <label for="_image_alt" class="control-label mb-1">Image Alt</label>
                                <input id="_image_alt" name="_image_alt" type="text" class="form-control" value="{{ isset($adsbanners) ? $adsbanners->_image_alt : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="banner_type_id" class="control-label mb-1">
                                    Banner Type
                                </label>
                                <select class="form-control" name="banner_type_id">
                                    <option value=""> ALL </option>
                                    @foreach($banner_types as $type)                                    
                                    <option value="{{ $type->id }}" {{ isset($adsbanners) ? ($adsbanners->banner_type_id == $type->id ? 'selected' : '') : '' }}>
                                        {{ $type->_name }}
                                    </option>
                                    @endforeach
                                </select>
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

                    <div class="row">
                        <div class='col-12'>
                            <div class="form-group">
                                <label for="_desc" class="control-label mb-1">Period</label>
                                    <div class='col-6 input-group date'>
                                        <input type='text' id='datetimepicker1' name="_start_date" value="{{ isset($adsbanners) ? $adsbanners->_start_date : '' }}"/>
                                        <!-- <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span> -->

                                        <label for="_desc" class="mb-1"> &nbsp;&nbsp;To&nbsp;&nbsp; </label>

                                        <input type='text' id='datetimepicker2' name="_end_date" value="{{ isset($adsbanners) ? $adsbanners->_end_date : '' }}"/>
                                        <!-- <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span> -->
                                    </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepicker1').datetimepicker({
                                            format: 'YYYY-MM-DD hh:mm:ss'
                                        });
                                        $('#datetimepicker2').datetimepicker({
                                            format: 'YYYY-MM-DD hh:mm:ss'
                                        });
                                    });
                                </script>
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