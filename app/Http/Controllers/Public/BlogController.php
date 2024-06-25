<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Domains\Blogs\Services\PostsService; 
use App\Domains\Categories\Services\CategoriesService;
use App\Domains\Paintings\Services\PaintingsService;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    protected $posts_service; 
    protected $paintings_service; 
    protected $categories_service;

    public function __construct(
         PostsService $posts_service ,
         PaintingsService $paintings_service,
         CategoriesService $categories_service,
          
    )
    {
        $this->posts_service       = $posts_service;
        $this->paintings_service   = $paintings_service;
        $this->categories_service  = $categories_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->posts_service->PostsWithPaginate(8);

        return view('public.blog',compact('posts'));
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
    public function show($slug)
    {
        $post = $this->posts_service->findPostBySlug($slug);
        $categories = $this->categories_service->SidebarCategories();
        $top_rated_paintings = $this->paintings_service->TopRated(4);//4=>limit
        return view('public.blog-details',compact('post','categories','top_rated_paintings'));
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
