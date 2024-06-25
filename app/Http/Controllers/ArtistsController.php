<?php

namespace App\Http\Controllers;

use App\Domains\Artists\Services\ArtistsService; 
use App\Domains\Categories\Services\CategoriesService;
use App\Domains\Permissions\Services\PermissionService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArtistsController extends Controller
{
    protected $artists_service; 
    protected $permission_service;
    protected $categories_service; 
    public function __construct(
         ArtistsService $artists_service , 
         PermissionService $permission_service,
         CategoriesService $categories_service, 
    )
    {
        $this->artists_service       = $artists_service;
        $this->permission_service = $permission_service;
        $this->categories_service      = $categories_service;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = $this->artists_service->prepare_data_table();
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){
                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ="";
                        if(in_array('13/edit', $modules_ids)):
                            $btn .=' <a href="'.route('artists.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('13/delete', $modules_ids)):
                            $btn .='<a href="'.route('artists.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;
                    })
                  
                    ->rawColumns(['actions'])
                    ->make(true);
        } 
       
        return view('artists.artists');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
       // Set the default date as today's date minus 10 years
        $defaultDate = Carbon::now()->subYears(10)->format('Y-m-d');
        $countries = $this->artists_service->countries();
        $artist = $this->artists_service->get_instance();
        $categories = $this->categories_service->all_by_type('artists');
        return view('artists.artists-form',compact('artist','countries','defaultDate','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $artist = $this->artists_service->create($request);
        return jsonResponse(['artist'=>$artist],200,__('Artist created successfully'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->artists_service->find($id);
        if($model){
            $defaultDate = Carbon::now()->subYears(10)->format('Y-m-d');
            $countries = $this->artists_service->countries();
            $artist = $this->artists_service->entity_to_data_model($model);
            $categories = $this->categories_service->all_by_type('artists');
            return view('artists.artists-form', compact('artist','countries','categories','defaultDate'));
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
        $artist = $this->artists_service->update($id,$request);
        return jsonResponse(['artist'=>$artist],200,__('Artist updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $artist = $this->artists_service->find($id);
        if (!$artist) {
            return response()->json(['message' => __('Artist already deleted!'),  'success' => false]);
        } else {
            try {
                $this->artists_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }

            return response()->json(['message' => __('Artist has been deleted!'),  'success' => true]);
        }

        return back();
    }
}
