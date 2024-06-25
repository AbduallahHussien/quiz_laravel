<?php

namespace App\Http\Controllers;

use App\Domains\Paintings\Services\PaintingsService;
use App\Domains\Categories\Services\CategoriesService;
use App\Domains\Artists\Services\ArtistsService;
use App\Domains\Themes\Services\ThemesService;
use App\Domains\Locations\Services\LocationsService;
use App\Domains\Colors\Services\ColorsService;
use App\Domains\Styles\Services\StylesService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class PaintingsController extends Controller
{
    protected $paintings_service; 
    protected $permission_service;
    protected $categories_service; 
    protected $themes_service; 
    protected $locations_service; 
    protected $colors_service; 
    protected $styles_service; 
    protected $artists_service; 
    public function __construct( 
        PaintingsService $paintings_service,
        CategoriesService $categories_service,
        ThemesService $themes_service,
        LocationsService $locations_service,
        ColorsService $colors_service,
        StylesService $styles_service,
        ArtistsService $artists_service,
     )
    {
        $this->paintings_service       = $paintings_service;
        $this->categories_service      = $categories_service;
        $this->themes_service          = $themes_service;
        $this->locations_service       = $locations_service;
        $this->colors_service          = $colors_service;
        $this->styles_service          = $styles_service;
        $this->artists_service          = $artists_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
 
            $data = $this->paintings_service->prepare_data_table();
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){
 
                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ='<a href="'.route('painting.show',$row->slug).'" class="action-btn" ><i class="fa fa-eye"></i></a>';
                        if(in_array('10/edit', $modules_ids)):
                            $btn .=' <a href="'.route('paintings.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('10/delete', $modules_ids)):
                            $btn .='<a href="'.route('paintings.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;
 
                    })
                    ->addColumn('status', function($row){
                        $status = '<span class="badge bg-success">'.__($row->status).'</span>';
                        if($row->status == 'unavailable'){
                            $status = '<span class="badge bg-warning text-dark">'.__($row->status).'</span>';
                        }else if($row->status == 'sold'){
                            $status = '<span class="badge bg-danger">'.__($row->status).'</span>';
                        }
                        return $status;
                    })
                  
                    ->rawColumns(['status','actions'])
                    ->make(true);
            
        } 
       
        return view('paintings.paintings');
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
        $painting = $this->paintings_service->get_instance();
        $categories = $this->categories_service->all_by_type('stock');
        $artist_categories = $this->categories_service->all_by_type('artists');
        $artists = $this->artists_service->all();
        $themes = $this->themes_service->all();
        $locations = $this->locations_service->all();
        $colors = $this->colors_service->all();
        $styles = $this->styles_service->all();
        $rows = [];
        $columns = [];
        return view('paintings.paintings-form',compact('painting','categories','themes','locations','colors','styles','artist_categories','artists','rows','columns'));
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $painting = $this->paintings_service->create($request);
        return jsonResponse(['painting'=>$painting],200,__('Painting created successfully'));
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


    public function upload_image_gallery(Request $request)
    {
        $id = $this->paintings_service->upload_image_gallery($request);
        return jsonResponse(['id'=>$id],200,__('Image uploaded successfully'));
    }
    public function remove_image_gallery(Request $request)
    {
        $id = $this->paintings_service->remove_image_gallery($request);
        return jsonResponse(['id'=>$id],200,__('Image deleted successfully'));
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->paintings_service->find($id);
        if($model){
            $painting = $this->paintings_service->entity_to_data_model($model);
            $categories = $this->categories_service->all_by_type('stock');
            $artist_categories = $this->categories_service->all_by_type('artists');
            $artists = $this->artists_service->all();
            $themes = $this->themes_service->all();
            $locations = $this->locations_service->all();
            $colors = $this->colors_service->all();
            $styles = $this->styles_service->all();
            $rows =  range(1, $painting->location->rows);
            $columns =  range(1, $painting->location->columns);
            return view('paintings.paintings-form', compact('painting','categories','themes','locations','colors','styles','artist_categories','artists','rows','columns'));
        }
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
        $painting = $this->paintings_service->update($id,$request);
        return jsonResponse(['painting'=>$painting],200,__('Painting updated successfully'));
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $painting = $this->paintings_service->find($id);
        if (!$painting) {
            return response()->json(['message' => __('Painting already deleted!'),  'success' => false]);
        } else {
             
            
            try {
                $this->paintings_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }
 
            return response()->json(['message' => __('Painting has been deleted!'),  'success' => true]);
        }
 
        return back();
    }

    /**
     * find paintings by barcode or name.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function findPaintings(Request $request)
    {
 
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $paintings = $this->paintings_service->findPaintingsByNameOrBarcode($term);

        $formatted_paintings = [];

        foreach ($paintings as $painting) {
            $formatted_paintings[] = ['id' => $painting->id, 'text' => $painting->name, 'price_sar' => $painting->price, 'price_euro' => $painting->price_euro];
        }

        return \Response::json($formatted_paintings);
    }
}
