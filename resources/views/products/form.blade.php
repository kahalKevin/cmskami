<link rel="stylesheet" href="{{ asset("/assets/admin/assets/css/lib/chosen/chosen.min.css")}}">

<div class="card">
    <div class="card-header">
        <strong class="card-title"><h3 class="text-center">Product Detail Data Form</h3></strong>
    </div>
    <div class="card-body">
        <!-- Credit Card -->
        <div id="pay-invoice">
            <div class="card-body">
            @if(isset($product))
                {{ Form::open(array('url'=>'category-product/product/'.$product->id , 'method' => 'PATCH', 'files'=>'true')) }}
            @else
                {{ Form::open(array('url'=>'category-product/product' , 'method'=>'POST','files'=>'true' )) }}
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
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="category_id" class="control-label mb-1">Category</label>
                                        <select class="form-control" name="category_id">
                                            <option value=""> -- Select --</option>                            
                                            @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ isset($product) && $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="gender_allocation_id" class="control-label mb-1">
                                            Gender Allocation
                                        </label>
                                        <select class="form-control" name="gender_allocation_id">
                                            <option value=""> ALL </option>   
                                            @foreach($gender_allocations as $ga)
                                            <option value="{{ $ga->id }}" {{ isset($product) && $product->gender_allocation_id == $ga->id ? 'selected' : ''  }}>
                                                {{ $ga->_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="_name" class="control-label mb-1">Name</label>
                                        <input id="_name" name="_name" type="text" class="form-control" value="{{ isset($product) ? $product->_name : '' }}" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12  ">
                                    <div class="form-group">
                                        <label for="_slug" class="control-label mb-1">Slug</label>
                                        <input id="_slug" name="_slug" type="text" class="form-control" value="{{ isset($product) ? $product->_slug : '' }}" placeholder="">
                                    </div>
                                </div>
                            </div>                    
                            @if (isset($product))
                            <div class="row">
                                <div class="col-12">
                                    <img src="{{ $product->_image_url }}">
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="_upload_image" class="control-label mb-1">Image</label>
                                    <input id="_upload_image" name="_upload_image" type="file" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="_price" class="control-label mb-1">Price</label>
                                        <input id="_price" name="_price" type="text" class="form-control" value="{{ isset($product) ? $product->_price : '' }}" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="_weight" class="control-label mb-1">Weight</label>
                                        <input id="_weight" name="_weight" type="text" class="form-control" value="{{ isset($product) ? $product->_weight : '' }}" placeholder="Gram">
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="_desc_product" class="control-label mb-1">Product Desc</label>
                                        <textarea name="_desc_product" id="_desc_product" rows="9" placeholder="" class="form-control">{{ isset($product) ? $product->_desc_product : '' }}</textarea>
                                        <script>
                                            CKEDITOR.replace( '_desc_product' );
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="_desc_delivery" class="control-label mb-1">Delivery Desc</label>
                                        <textarea name="_desc_delivery" id="_desc_delivery" rows="9" placeholder="" class="form-control">{{ isset($product) ? $product->_desc_delivery : '' }}</textarea>
                                        <script>
                                            CKEDITOR.replace( '_desc_delivery' );
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="_desc_size" class="control-label mb-1">Size Desc</label>
                                        <textarea name="_desc_size" id="_desc_size" rows="9" placeholder="" class="form-control">{{ isset($product) ? $product->_desc_size : '' }}</textarea>
                                        <script>
                                            CKEDITOR.replace( '_desc_size' );
                                        </script>
                                    </div>
                                </div>
                            </div>                                                        
                        </div>                         
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="_meta_title" class="control-label mb-1">Meta Title</label>
                                        <input id="_meta_title" name="_meta_title" type="text" class="form-control" value="{{ isset($product) ? $product->_meta_title : '' }}" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="_meta_desc" class="control-label mb-1">Meta Desc</label>
                                        <textarea name="_meta_desc" id="_meta_desc" rows="9" placeholder="" class="form-control">{{ isset($product) ? $product->_meta_desc : '' }}</textarea>
                                    </div>
                                </div>
                            </div>                      
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="_meta_keyword" class="control-label mb-1">Meta Keyword</label>
                                        <input id="_meta_keyword" name="_meta_keyword" type="text" class="form-control" value="{{ isset($product) ? $product->_meta_keyword : '' }}" placeholder="">
                                    </div>
                                </div>
                            </div>                                          
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="_active" class="control-label mb-1">Active?</label>
                                        <select class="form-control" name="_active">
                                        @if(isset($product))
                                            <option value="1" {{ $product->_active == '1' ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ $product->_active == '0' ? 'selected' : '' }}>No</option>
                                        @else
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        @endif
                                        </select>
                                    </div>
                                </div>
                            </div>                                                     
                        </div>                      
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                            <label for="_active" class="control-label mb-1">Tags</label>
                                <select data-placeholder="Choose tags" multiple class="standardSelect" name="tags[]"> 
                                    @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}"
                                        @if(isset($product))
                                        @foreach($tags_selected as $ts)
                                            @if($ts->id == $tag->id)
                                            selected
                                            @endif
                                        @endforeach
                                        @endif                                        
                                    >{{ $tag->name }}</option>
                                    @endforeach                             
                                </select>
                            </div>
                        </div>
                    </div>                                                                         
                    <div>
                        <button type="submit" class="btn btn-success"><strong>{{ isset($product) ? 'Update' : 'Create' }}</strong></button>
                    </div>                
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>
<script src={{ asset("/assets/admin/assets/js/vendor/jquery-2.1.4.min.js")}}></script>
<script src={{ asset("/assets/admin/assets/js/lib/chosen/chosen.jquery.min.js")}}></script>

<script type="text/javascript">
    var $ = jQuery;
    $(document).ready(function() {
        $('.standardSelect').chosen({
                disable_search_threshold: 10,
                no_results_text: "Oops, nothing found!",
                width: "100%"
          });
    });
</script>