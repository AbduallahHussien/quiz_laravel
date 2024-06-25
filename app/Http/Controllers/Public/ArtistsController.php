<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Domains\Artists\Services\ArtistsService;
use App\Domains\Categories\Services\CategoriesService;
use App\Domains\Paintings\Services\PaintingsService;
use App\Domains\Colors\Services\ColorsService;

use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    protected $artists_service; 
    protected $paintings_service; 
    protected $categories_service;
    protected $colors_service;  



    public function __construct(
        ArtistsService $artists_service , 
        PaintingsService $paintings_service,
        CategoriesService $categories_service,
        ColorsService $colors_service,
  
    )
    {
        $this->artists_service       = $artists_service;
        $this->paintings_service   = $paintings_service;
        $this->categories_service  = $categories_service;
        $this->colors_service      = $colors_service;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artists    = $this->artists_service->all();
        $data = [];
        if($artists){

            foreach($artists as $artist):
                $arr = [];
                $paintings = $this->paintings_service->PaintingByArtistId($artist->id ,4);
                $arr ['artist'] = $artist;
                $arr ['paintings'] = $paintings;
                $data[]= $arr;

            endforeach;
            $categories = $this->categories_service->SidebarCategories();
            $colors = $this->colors_service->all();
            $top_rated_paintings = $this->paintings_service->TopRated(4);//4=>limit
            return view('public.artists',compact('data','categories','colors','top_rated_paintings'));
        }else{
            abort(404);
        }
    }


    public function profile()
    {
        return view('public.artist-profile');
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
