<?php

namespace App\Http\Controllers;

use App\Domains\History\Services\HistoryService; 
use App\Domains\Permissions\Services\PermissionService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HistoryController extends Controller
{

    protected $history_service; 
    protected $permission_service;
    public function __construct( HistoryService $history_service , PermissionService $permission_service )
    {
        $this->history_service    = $history_service;
        $this->permission_service = $permission_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function display(Request $request, $model_name, $model_id)
    {
        if ($request->ajax()) {

            $data = $this->history_service->prepare_data_table($model_name, $model_id);
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('description', function($row){
                        return  decodeAndDisplayAsCommaList($row->description);
                    })
                  
                    ->rawColumns(['description'])
                    ->make(true);
            
        } 
       
    }
}
