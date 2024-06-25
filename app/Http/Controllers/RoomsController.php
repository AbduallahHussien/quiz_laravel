<?php

namespace App\Http\Controllers;

use App\Domains\Rooms\Services\RoomsService; 
use App\Domains\Permissions\Services\PermissionService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RoomsController extends Controller
{
    protected $rooms_service; 
    protected $permission_service;
    public function __construct( RoomsService $rooms_service , PermissionService $permission_service )
    {
        $this->rooms_service       = $rooms_service;
        $this->permission_service = $permission_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = $this->rooms_service->prepare_data_table();
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){

                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ="";
                        if(in_array('17/edit', $modules_ids)):
                            $btn .=' <a href="'.route('rooms.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('17/delete', $modules_ids)):
                            $btn .='<a href="'.route('rooms.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;

                    })
                  
                    ->rawColumns(['actions'])
                    ->make(true);
            
        } 
       
        return view('rooms.rooms');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $room = $this->rooms_service->get_instance();
        return view('rooms.rooms-form',compact('room'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $room = $this->rooms_service->create($request);
        return jsonResponse(['room'=>$room],200,__('Room created successfully'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->rooms_service->find($id);
        if($model){
            $room = $this->rooms_service->entity_to_data_model($model);
            return view('rooms.rooms-form', compact('room'));
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
        $room = $this->rooms_service->update($id,$request);
        return jsonResponse(['room'=>$room],200,__('Room updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = $this->rooms_service->find($id);
        if (!$room) {
            return response()->json(['message' => __('Room already deleted!'),  'success' => false]);
        } else {
             
            
            try {
                $this->rooms_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }

            return response()->json(['message' => __('Room has been deleted!'),  'success' => true]);
        }

        return back();
    }

    /**
     * find rooms by barcode or name.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function findRooms(Request $request)
    {
 
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $rooms = $this->rooms_service->findRoomsByName($term);

        $formatted_rooms = [];

        foreach ($rooms as $room) {
            $formatted_rooms[] = ['id' => $room->id, 'text' => $room->name];
        }

        return \Response::json($formatted_rooms);
    }

}
