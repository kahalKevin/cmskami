<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Category as Category;
use App\Http\Model\Type as Type;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Datatables;
use Auth;

class CategoryController extends Controller
{
    //For Validation
    protected $rules_create = array(
            '_name'       => 'required',
            '_slug'      => 'required|unique:cms_tm_category'
    );
    
    protected $rules_update = array(
            '_name'       => 'required',
            '_slug'      => 'required'
    );
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category_parents = Category::query()->where('parent_category_id', '=', null)->get();
        $gender_allocations = Type::query()->where('category_id', 11)->get();
        if(isset($request->category_parent))
        $category_childs = Category::query()->where('parent_category_id', '=' , $request->category_parent)->get();    
        return view('categories.index')->with(compact('category_parents', 'gender_allocations', 'request', 'category_childs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_parents = Category::query()->get();
        $gender_allocations = Type::query()->where('category_id', 11)->get();
        return view('categories.create')->with(compact('category_parents', 'gender_allocations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
                '_upload_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $this->validate($request, $this->rules_create);

         $image = $request->file('_upload_image');

        $imageName = $image->getClientOriginalName();
        $path = $image->store('public/images/category');
        $publicPath = \Storage::url($path);
        $category = Category::create($request->all() + [
            'created_by' =>  Auth::user()->id,
            '_image_real_name' => $imageName, 
            '_image_enc_name' => $image->hashName(), 
            '_image_url' => $publicPath
        ]);
        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just created new Category');
        return redirect()->route("category.index"); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $category_parents = Category::query()->get();
        $gender_allocations = Type::query()->where('category_id', 11)->get();        
        return view('categories.edit')->with(compact('category', 'category_parents', 'gender_allocations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->_upload_image != null){
            request()->validate([
                '_upload_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);
        }

        $this->validate($request, $this->rules_update);
        $category = Category::find($id);
            $category->parent_category_id = $request->parent_category_id;        
            $category->gender_allocation_id = $request->gender_allocation_id;
            $category->_name = $request->_name;        
            $category->_slug = $request->_slug;
            $category->_desc = $request->_desc;                                
            $category->_meta_title = $request->_meta_title;       
            $category->_meta_desc = $request->_meta_desc;
            $category->_meta_keyword = $request->_meta_keyword;       
            $category->_active = $request->_active;
            $category->updated_by =  Auth::user()->id;

            //for image
            if($request->_upload_image != null){
                $image = $request->file('_upload_image');
                $imageName = $image->getClientOriginalName();
                $path = $image->store('public/images/category');
                $publicPath = \Storage::url($path);

                $category->_image_real_name = $imageName;
                $category->_image_enc_name = $image->hashName();
                $category->_image_url = $publicPath;
            }            
        $category->save();
        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just update '. $category->_name);
        return redirect()->route("category.index");                
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories = Category::where('parent_category_id','=', $id)->get();
        foreach ($categories as $cat) {
            $cat->_active = '0';
            $cat->save();
        }
        
        $category = Category::find($id);
        $category->_active = '0';
        $category->save();
        \Session::flash('flash_message','You have just delete '. $category->_name);
    }

    public function loadData(Request $request)
    {   
        if(!isset($request->status)) {
            $status = '1';       
        } else {
            $status = $request->status;
        }

        $query = \DB::table('cms_tm_category AS cat1')
                    ->leftjoin('cms_tm_category AS cat2', 'cat1.parent_category_id', '=', 'cat2.id')
                    ->leftjoin('sys_type AS type', 'cat1.gender_allocation_id', '=', 'type.id')
                    ->select(
                        'cat1.id',
                        'cat1._name AS category_name', 
                        'cat2._name AS parent_category_name',
                        'type._name AS gender_name',
                        'cat1._slug',
                        'cat1._active'                        
                        )
                    ->where('cat1._name','LIKE', '%'.$request->name.'%');
            
            if(isset($request->status)) {
                $status = '1';
                if($request->status == 'false'){
                    $status = '0';
                }
                $query = $query->where('cat1._active', '=' , $status);
            }
            if(isset($request->genAlloc)) {
                $query = $query->where('cat1.gender_allocation_id', '=' , $request->genAlloc);
            }
            if(isset($request->categoryParent)) {
                $query = $query->where(function($q) use ($request) {
                              $q->where('cat1.id','=', $request->categoryParent)
                                ->orWhere('cat1.parent_category_id','=', $request->categoryParent);
                              });
            }   
            if(isset($request->categoryChild)) {
                $query = $query->where(function($q) use ($request) {
                              $q->where('cat1.id','=' ,$request->categoryChild)
                                ->orWhere('cat1.parent_category_id','=', $request->categoryChild);
                              });
            }                        
            
        return Datatables::of($query->get())->addIndexColumn()->make(true);
    }

    public function getCategoryChild($id) {
        $categories = Category::query()->where("parent_category_id",$id)->pluck("_name","id");
        return json_encode($categories);
    }
}
