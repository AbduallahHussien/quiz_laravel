<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Domains\Categories\Services\CategoriesService;
use App\Domains\Paintings\Services\PaintingsService;
use App\Domains\Colors\Services\ColorsService;
use Illuminate\Http\Request;

class PaintingsCategoryController extends Controller
{
    protected $paintings_service; 
    protected $categories_service;
    protected $colors_service;  
   
    public function __construct( 
        PaintingsService $paintings_service,
        CategoriesService $categories_service,
        ColorsService $colors_service,
       
     )
    {
        $this->paintings_service       = $paintings_service;
        $this->categories_service      = $categories_service;
        $this->colors_service          = $colors_service;
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug,Request $request)
    {
        $search = '';
        $sort_by = '';
        if ($request->has('sort_by')) {
            $sort_by = $request->input('sort_by');
        }
        if ($request->has('search')) {
            $search = $request->input('search');
        }
        if($slug && $slug!='all-categories'){
            $category = $this->categories_service->findCategoryBySlug($slug)[0];
            $paintings = $this->paintings_service->PaintingByCategoryId($category->id,12,$search,$sort_by);
        }else{
            $category = (object)['name' => __('All Categories')];
            $paintings = $this->paintings_service->PaintingByCategoryId($slug,12,$search,$sort_by);
        }
       
        $categories = $this->categories_service->SidebarCategories();
        $colors = $this->colors_service->all();
        $top_rated_paintings = $this->paintings_service->TopRated(4);//4=>limit
        return view('public.painting-category',compact('category','paintings','categories','colors','top_rated_paintings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
