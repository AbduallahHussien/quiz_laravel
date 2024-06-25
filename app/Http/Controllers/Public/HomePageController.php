<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Domains\Paintings\Services\PaintingsService;
use App\Domains\Categories\Services\CategoriesService;
use App\Domains\Artists\Services\ArtistsService;
use App\Domains\Blogs\Services\PostsService;
use App\Domains\Locations\Services\LocationsService;
use App\Domains\Colors\Services\ColorsService;
use App\Domains\Styles\Services\StylesService;
use App\Domains\Slides\Services\SlidesService;
use Illuminate\Http\Request;
use App\Domains\Settings\Interfaces\SettingsRepositoryInterface;
use Session;

class HomePageController extends Controller
{
    protected $paintings_service; 
    protected $permission_service;
    protected $categories_service; 
    protected $posts_service; 
    protected $locations_service; 
    protected $colors_service; 
    protected $styles_service; 
    protected $artists_service; 
    protected $slides_service; 
    private $settings_respository;
    public function __construct( 
        PaintingsService $paintings_service,
        CategoriesService $categories_service,
        PostsService $posts_service,
        LocationsService $locations_service,
        ColorsService $colors_service,
        StylesService $styles_service,
        ArtistsService $artists_service,
        SlidesService $slides_service,
        SettingsRepositoryInterface $settings_respository
     )
    {
        $this->paintings_service       = $paintings_service;
        $this->categories_service      = $categories_service;
        $this->posts_service           = $posts_service;
        $this->locations_service       = $locations_service;
        $this->colors_service          = $colors_service;
        $this->styles_service          = $styles_service;
        $this->artists_service         = $artists_service;
        $this->slides_service          = $slides_service;
        $this->settings_respository = $settings_respository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners           =  $this->paintings_service->getPaintings(true, 3);
        $products          =  $this->paintings_service->getPaintings(true, 5);
        $featured_artist   =  $this->artists_service->featuredArtist(true, 8);
        $artist_categories =  $this->artists_service->artistCategories();
        $posts             =  $this->posts_service->featuredPosts(3);
        $slides            =  $this->slides_service->homeSlides();

        return view('public.home', compact('banners','products','featured_artist','artist_categories','posts','slides'));
    }
    
    public function site_lang(Request $request)
    {
        \Session::put('language', $request->lang);
        $this->settings_respository->update_settings('language',$request->lang);  


        return jsonResponse(['data'=>''],200,'');

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
