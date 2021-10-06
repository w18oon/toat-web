<?php

namespace App\Http\Controllers\IE\Settings;

use App\Models\IE\Category;
use App\Models\IE\Icon;

use App\Http\Requests\IE\CategoriesStoreRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CategoriesController extends Controller
{
    protected $orgId;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     $this->orgId = \Auth::user()->org_id;
        //     return $next($request);
        // });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::active()->get();
        return view('ie.settings.categories.index', compact('categories'));
    }

    public function create()
    {
        $iconLists = Icon::data()->sortBy('name')->pluck('name','code')->all();
        return view('ie.settings.categories.create',
            compact('iconLists'));
    }

    public function store(CategoriesStoreRequest $request)
    {
        $category = new Category();
        // $category->org_id = $this->orgId;
        $category->name = $request->name;
        $category->icon = $request->icon ? $request->icon : null;
        $category->description = $request->description;
        $category->last_updated_by = -1;
        $category->created_by = -1;
        $category->save();

        return redirect()->route('ie.settings.categories.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $iconLists = Icon::data()->sortBy('name')->pluck('name','code')->all();
        return view('ie.settings.categories.edit', compact('category','iconLists'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesStoreRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->icon = $request->icon ? $request->icon : null;
        $category->description = $request->description;
        $category->last_updated_by = -1;
        $category->created_by = -1;
        $category->save();

        return redirect()->route('ie.settings.categories.index');
    }

    public function remove(Request $request, Category $category)
    {
        \DB::beginTransaction();
        try {
            // INACTIVE SUBCATEGORY OF THIS CATEGORY
            if(count($category->subCategories) > 0){
                foreach($category->subCategories as $subCategory){
                    $subCategory->active = false;
                    $subCategory->save();
                }
            }
            // REMOVE CATEGORY
            $category->active = false;
            $category->save();

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }
        \DB::commit();

        if($request->ajax()){
            return \Response::json("success", 200);
        }else{
            return redirect()->route('ie.settings.categories.index');
        }
    }

}
