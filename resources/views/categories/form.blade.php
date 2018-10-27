<div class="card">
    <div class="card-header">
        <strong class="card-title"><h3 class="text-center">Category Form</h3></strong>
    </div>
    <div class="card-body">
        <!-- Credit Card -->
        <div id="pay-invoice">
            <div class="card-body">
            @if(isset($category))
                {{ Form::open(array('url'=>'category-product/category/'.$category->id , 'method' => 'PATCH', 'files'=>'true')) }}
            @else
                {{ Form::open(array('url'=>'category-product/category' , 'method'=>'POST','files'=>'true' )) }}
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
                                <label for="parent_category_id" class="control-label mb-1">Category Parent</label>
                                <select class="form-control" name="parent_category_id">
                                    <option value=""> -- NONE --</option>                            
                                    @foreach($category_parents as $cp)
                                    <option value="{{ $cp->id }}" {{ isset($category) && $category->parent_category_id == $cp->id ? 'selected' : '' }}>{{ $cp->_name }}</option>
                                    @endforeach
                              </select>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="gender_allocation_id" class="control-label mb-1">
                                    Gender Allocation
                                </label>
                                <select class="form-control" name="gender_allocation_id">
                                    <option value=""> ALL </option>   
                                    @foreach($gender_allocations as $ga)
                                    <option value="{{ $ga->id }}" {{ isset($category) && $category->gender_allocation_id == $ga->id }}>
                                        {{ $ga->_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_name" class="control-label mb-1">Name</label>
                                <input id="_name" name="_name" type="text" class="form-control" value="{{ isset($category) ? $category->_name : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_slug" class="control-label mb-1">Slug</label>
                                <input id="_slug" name="_slug" type="text" class="form-control" value="{{ isset($category) ? $category->_slug : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_desc" class="control-label mb-1">Desc</label>
                                <textarea name="_desc" id="_desc" rows="9" placeholder="" class="form-control">{{ isset($category) ? $category->_desc : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    @if (isset($category))
                    <div class="row">
                        <div class="col-6">
                            <img src="{{ $category->_image_url }}">
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_upload_image" class="control-label mb-1">Image</label>
                            <input id="_upload_image" name="_upload_image" type="file" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_meta_title" class="control-label mb-1">Meta Title</label>
                                <input id="_meta_title" name="_meta_title" type="text" class="form-control" value="{{ isset($category) ? $category->_meta_title : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_meta_desc" class="control-label mb-1">Meta Desc</label>
                                <textarea name="_meta_desc" id="_meta_desc" rows="9" placeholder="" class="form-control">{{ isset($category) ? $category->_meta_desc : '' }}</textarea>
                            </div>
                        </div>
                    </div>                      
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_meta_keyword" class="control-label mb-1">Meta Keyword</label>
                                <input id="_meta_keyword" name="_meta_keyword" type="text" class="form-control" value="{{ isset($category) ? $category->_meta_keyword : '' }}" placeholder="">
                            </div>
                        </div>
                    </div>                                          
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="_active" class="control-label mb-1">Active?</label>
                                <select class="form-control" name="_active">
                                @if(isset($category))
                                    <option value="1" {{ $category->_active == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $category->_active == '0' ? 'selected' : '' }}>No</option>
                                @else
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                @endif
                                </select>
                            </div>
                        </div>
                    </div>                             
                    <div>
                        <button type="submit" class="btn btn-success"><strong>{{ isset($category) ? 'Update' : 'Create' }}</strong></button>
                    </div>                
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>