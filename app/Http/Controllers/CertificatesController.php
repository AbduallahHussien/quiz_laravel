<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\Certificates\Services\CertificatesService;
use App\Domains\Customers\Services\CustomersService; 
use Yajra\DataTables\Facades\DataTables;
class CertificatesController extends Controller
{
    protected $certificates_service; 
    protected $customers_service;  
    protected $permission_service;
    public function __construct( CertificatesService $certificates_service ,CustomersService $customers_service )
    {
        $this->certificates_service       = $certificates_service;
        $this->customers_service       = $customers_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
 
            $data = $this->certificates_service->prepare_data_table($request->item_id);
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){
 
                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ="";
                        if(in_array('12/edit', $modules_ids)):
                            $btn .=' <a href="'.route('certificates.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('12/delete', $modules_ids)):
                            $btn .='<a href="'.route('certificates.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;
 
                    })
                  
                    ->rawColumns(['actions'])
                    ->make(true);
            
        } 
       
        return view('certificates.certificates');
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $painting_id = $request->painting_id;
        if(!$painting_id) die;
        $certificate = $this->certificates_service->get_instance();
        return view('certificates.certificates-form',compact('certificate','painting_id'));
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $certificate = $this->certificates_service->create($request);
        return jsonResponse(['certificate'=>$certificate,'redirect_url'=> route('paintings.edit',$certificate->painting_id)],200,__('Certificate created successfully'));
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
        $model = $this->certificates_service->find($id);
        if($model){
            $certificate = $this->certificates_service->entity_to_data_model($model);
            return view('certificates.certificates-form', compact('certificate'));
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
        $certificate = $this->certificates_service->update($id,$request);
        return jsonResponse(['certificate'=>$certificate, 'redirect_url'=> route('paintings.edit',$certificate->painting_id)],200,__('Certificate updated successfully'));
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $certificate = $this->certificates_service->find($id);
        if (!$certificate) {
            return response()->json(['message' => __('Certificate already deleted!'),  'success' => false]);
        } else {
             
            
            try {
                $this->certificates_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }
 
            return response()->json(['message' => __('Certificate has been deleted!'),  'success' => true]);
        }
 
        return back();
    }
}
