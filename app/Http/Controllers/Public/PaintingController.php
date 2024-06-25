<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Domains\Paintings\Services\PaintingsService;
use Illuminate\Http\Request;

class PaintingController extends Controller
{

    protected $paintings_service; 
 
    public function __construct( 
        PaintingsService $paintings_service,
       
     )
    {
        $this->paintings_service       = $paintings_service;
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
       $painting = $this->paintings_service->findPaintingBySlug($slug);
       if($painting){
            $artist_paintings = $this->paintings_service->PaintingByArtistId($painting[0]->artist_id,3);
            return view('public.painting-details',compact('painting','artist_paintings'));

       }else{
        abort(404);
       }
    }

    public function makePaintingAs(Request $request)
    {
        $painting = $this->paintings_service->makePaintingAs($request);
        return jsonResponse(['painting'=>$painting],200,__('Done'));
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
