<link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/daterangepicker.css")}}">
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
                        <div class='col-6'>
                            <div class="form-group">
                                <label for="_desc" class="control-label mb-1">Period</label>
                                    <div>
                                        <input type='text' id='_period' name="_period" value="{{ isset($period) ? $period : '' }}"  class="form-control dateRangePickerAds" {{ isset($period) ? 'readonly' : '' }} />
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_active" class="control-label mb-1">Active?</label>
                                <select class="form-control" name="_active">
                                @if(isset($sleeves))
                                    <option value="1" {{ $sleeves->_active == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $sleeves->_active == '0' ? 'selected' : '' }}>No</option>
                                @else
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                @endif
                                </select>
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

<script src={{ asset("/assets/admin/assets/js/vendor/jquery-2.1.4.min.js")}}></script>
<script src={{ asset("/assets/admin/assets/js/moment.min.js")}}></script>        
<script src={{ asset("/assets/admin/assets/js/daterangepicker.min.js")}}></script>    
<script type="text/javascript">
    var $ = jQuery;
    $(document).ready(function() {
        @php 
            if (!isset($period))  {
                echo "var disabledArr = " . json_encode($disabled_dates) . ";";
            } else {
                echo "var disabledArr = [];";
            }
        @endphp

        $('.dateRangePickerAds').daterangepicker({
        autoUpdateInput: false,
        timePicker: false,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            minDate: new Date(),
            isInvalidDate: function(arg){
                console.log(arg);

                // Prepare the date comparision
                var thisMonth = arg._d.getMonth()+1;   // Months are 0 based
                if (thisMonth<10){
                    thisMonth = "0"+thisMonth; // Leading 0
                }
                var thisDate = arg._d.getDate();
                if (thisDate<10){
                    thisDate = "0"+thisDate; // Leading 0
                }
                var thisYear = arg._d.getYear()+1900;   // Years are 1900 based

                var thisCompare = thisMonth +"/"+ thisDate +"/"+ thisYear;
                console.log(thisCompare);

                if($.inArray(thisCompare,disabledArr)!=-1){
                    console.log("      ^--------- DATE FOUND HERE");
                    return true;
                }
            },
            locale: {
              format: 'YYYY-MM-DD',
              cancelLabel: 'Clear'
            }
        });
    });
    $('.dateRangePickerAds').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('.dateRangePickerAds').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });
</script>