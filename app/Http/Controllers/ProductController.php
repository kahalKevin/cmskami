<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Product as Product;
use App\Http\Model\Category as Category;
use App\Http\Model\Type as Type;
use App\Http\Model\Sleeve as Sleeve;
use App\Http\Model\Tag as Tag;
use App\Http\Model\League as League;
use App\Http\Model\Club as Club;
use App\Http\Model\Player as Player;
use App\Http\Model\ProductTag as ProductTag;
use App\Http\Model\ProductStock as ProductStock;
use App\Http\Model\ProductGallery as ProductGallery;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Redirect;
use Datatables;
use Auth;

class ProductController extends Controller
{
    //For Validation
    //For Validation
    protected $rules_create = array(
            '_name'     => 'required',
            '_slug'     => 'required|unique:cms_tm_product',
            '_price'    => 'required',
            '_weight'   => 'required'
    );
    
    protected $rules_update = array(
            '_name'       => 'required',
            '_slug'      => 'required',
            '_price'    => 'required',
            '_weight'   => 'required'
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
        return view('products.index')->with(compact('category_parents', 'gender_allocations', 'request', 'category_childs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::query()->where('_active', '=' , '1')->get();
        $gender_allocations = Type::query()->where('category_id', 11)->get();
        
        //For tags
        $tags = $this->getTags();
        return view('products.create')->with(compact('request', 'categories', 'gender_allocations', 'tags'));
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
        $path = $image->store('public/images/product');
        $publicPath = \Storage::url($path);        

        $product = Product::create($request->all() + [
            'created_by' =>  Auth::user()->id,
            '_image_real_name' => $imageName, 
            '_image_enc_name' => $image->hashName(), 
            '_image_url' => $publicPath
        ]);

        foreach ($request->tags as $tag) {
            $this->storeTags($tag, $product->id);
        }             

        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just created new Product');
        return redirect()->route("product.index");
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
        $product = Product::find($id);
        $categories  = Category::query()->get();
        $gender_allocations = Type::query()->where('category_id', 11)->get();       
        $tags = $this->getTags(); 
        $tags_selected = $this->getTagsSelected($id);
        return view('products.edit')->with(compact('categories', 'product', 'gender_allocations' ,'tags' , 'tags_selected'));
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
        $product = Product::find($id);
            $product->category_id = $request->category_id;        
            $product->gender_allocation_id = $request->gender_allocation_id;
            $product->_name = $request->_name;        
            $product->_slug = $request->_slug;
            $product->_meta_title = $request->_meta_title;       
            $product->_meta_desc = $request->_meta_desc;
            $product->_meta_keyword = $request->_meta_keyword;
            $product->_price = $request->_price;        
            $product->_weight = $request->_weight;
            $product->_desc_product = $request->_desc_product;       
            $product->_desc_delivery = $request->_desc_delivery;
            $product->_desc_size = $request->_desc_size;                   
            $product->_active = $request->_active;
            $product->updated_by =  Auth::user()->id;

            //for image
            if($request->_upload_image != null){
                $image = $request->file('_upload_image');
                $imageName = $image->getClientOriginalName();
                $path = $image->store('public/images/product');
                $publicPath = \Storage::url($path);

                $product->_image_real_name = $imageName;
                $product->_image_enc_name = $image->hashName();
                $product->_image_url = $publicPath;
            }            
        $product->save();

        //Update Product Tags
        $tags_deleted = ProductTag::where('product_id',$id)->delete();
        foreach ($request->tags as $tag) {
            $this->storeTags($tag, $id);
        }  

        //PUT HERE AFTER YOU SAVE
        \Session::flash('flash_message','You have just update '. $product->_name);
        return redirect()->route("product.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $tags_deleted = ProductTag::where('product_id',$product->id)->delete();
        $product_stock_deleted = ProductStock::where('product_id',$product->id)->delete();
        $product_gallery_deleted = ProductGallery::where('product_id',$product->id)->delete();
        $product->delete();
        \Session::flash('flash_message','You have just delete '. $product->_name);
    }

    public function loadData(Request $request)
    {   
        if(!isset($request->status)) {
            $status = '1';       
        } else {
            $status = $request->status;
        }

        $query = \DB::table('cms_tm_product AS product')
                    ->leftjoin('cms_tm_category AS cat1', 'product.category_id', '=', 'cat1.id')        
                    ->leftjoin('sys_type AS type', 'product.gender_allocation_id', '=', 'type.id')
                    ->select(
                        'product.id',
                        'product._image_url',
                        'product._image_real_name',
                        'cat1._name AS category_name', 
                        'type._name AS gender_name',
                        'product._name',
                        'product._slug',
                        'product._price',
                        'product._count_view',
                        'product._count_buy',
                        'product._active'                        
                        )
                    ->where('product._name','LIKE', '%'.$request->name.'%');
            
        if(isset($request->status)) {
            $status = '1';
            if($request->status == 'false'){
                $status = '0';
            }
            $query = $query->where('product._active', '=' , $status);
        }

        if(isset($request->genAlloc)) {
            $query = $query->where('product.gender_allocation_id', '=' , $request->genAlloc);
        }
        if(isset($request->categoryParent)) {
            $query = $query->where('product.category_id', '=' , $request->categoryParent);
        }   
        if(isset($request->categoryChild)) {
            $query = $query->where('product.category_id', '=' , $request->categoryChild);
        }
        
        $query = $query->where('product.deleted_at', '=' , null);                                                          
            
        return Datatables::of($query->get())->addIndexColumn()->make(true);
    }

    function getTags()
    {   
        $sleeves = Sleeve::get();
        $leagues = League::get();
        $clubs = Club::get();  
        $players = Player::get();

        $arr_tags[] = new Tag();

        $index = 0;
        foreach ($clubs as $club) {
            $arr_tags[$index] = new Tag();
            $arr_tags[$index]->id = "club-".$club->id;
            $arr_tags[$index]->name = "club - ".$club->_name;
            $index++;            
        }

        foreach ($leagues as $league) {
            $arr_tags[$index] = new Tag();
            $arr_tags[$index]->id = "league-".$league->id;
            $arr_tags[$index]->name = "league - ".$league->_name;
            $index++;            
        }

        foreach ($sleeves as $sleeve) {
            $arr_tags[$index] = new Tag();
            $arr_tags[$index]->id = "sleeve-".$sleeve->id;
            $arr_tags[$index]->name = "sleeve - ".$sleeve->_name;
            $index++;            
        } 

        foreach ($players as $player) {
            $arr_tags[$index] = new Tag();
            $arr_tags[$index]->id = "player-".$player->id;
            $arr_tags[$index]->name = "player - ".$player->_name;
            $index++;            
        } 
        return $arr_tags;
    }    

    public function storeTags($tag, $product_id)
    {   
        $exp_tag = explode("-",$tag);
        if($exp_tag[0] == "club") {
            $product_tag = new ProductTag();
            $product_tag->product_id = $product_id;
            $product_tag->club_id = $exp_tag[1];
            $product_tag->created_by = Auth::user()->id; 
            $product_tag->created_at = Carbon::now();
            $product_tag->save();
        }

        if($exp_tag[0] == "league") {
            $product_tag = new ProductTag();
            $product_tag->product_id = $product_id;
            $product_tag->league_id = $exp_tag[1];
            $product_tag->created_by = Auth::user()->id;
            $product_tag->created_at = Carbon::now();            
            $product_tag->save();
        }

        if($exp_tag[0] == "player") {
            $product_tag = new ProductTag();
            $product_tag->product_id = $product_id;
            $product_tag->player_id = $exp_tag[1];
            $product_tag->created_by = Auth::user()->id;
            $product_tag->created_at = Carbon::now();            
            $product_tag->save();
        }

        if($exp_tag[0] == "sleeve") {
            $product_tag = new ProductTag();
            $product_tag->product_id = $product_id;
            $product_tag->sleeve_id = $exp_tag[1];
            $product_tag->created_by = Auth::user()->id;
            $product_tag->created_at = Carbon::now();            
            $product_tag->save();
        }
    }
    function getTagsSelected($id)
    {   
        $sleeves = ProductTag::join('cms_tm_sleeve','cms_tm_product_tag.sleeve_id','cms_tm_sleeve.id')
            ->select(
                      'cms_tm_sleeve.id',
                      'cms_tm_sleeve._name'
              )
            ->where('cms_tm_product_tag.product_id', '=' , $id)
            ->get();

        $leagues = ProductTag::join('cms_tm_league','cms_tm_product_tag.league_id','cms_tm_league.id')
            ->select(
                      'cms_tm_league.id',
                      'cms_tm_league._name'
              )
            ->where('cms_tm_product_tag.product_id', '=' , $id)
            ->get();

        $clubs = ProductTag::join('cms_tm_club','cms_tm_product_tag.club_id','cms_tm_club.id')
            ->select(
                      'cms_tm_club.id',
                      'cms_tm_club._name'
              )
            ->where('cms_tm_product_tag.product_id', '=' , $id)
            ->get();

        $players = ProductTag::join('cms_tm_player','cms_tm_product_tag.player_id','cms_tm_player.id')
            ->select(
                      'cms_tm_player.id',
                      'cms_tm_player._name'
              )
            ->where('cms_tm_product_tag.product_id', '=' , $id)
            ->get();
                                                
        $arr_tags[] = new Tag();

        $index = 0;
        foreach ($clubs as $club) {
            $arr_tags[$index] = new Tag();
            $arr_tags[$index]->id = "club-".$club->id;
            $arr_tags[$index]->name = "club - ".$club->_name;
            $index++;            
        }

        foreach ($leagues as $league) {
            $arr_tags[$index] = new Tag();
            $arr_tags[$index]->id = "league-".$league->id;
            $arr_tags[$index]->name = "league - ".$league->_name;
            $index++;            
        }

        foreach ($sleeves as $sleeve) {
            $arr_tags[$index] = new Tag();
            $arr_tags[$index]->id = "sleeve-".$sleeve->id;
            $arr_tags[$index]->name = "sleeve - ".$sleeve->_name;
            $index++;            
        } 

        foreach ($players as $player) {
            $arr_tags[$index] = new Tag();
            $arr_tags[$index]->id = "player-".$player->id;
            $arr_tags[$index]->name = "player - ".$player->_name;
            $index++;            
        } 
        return $arr_tags;
    }
}
