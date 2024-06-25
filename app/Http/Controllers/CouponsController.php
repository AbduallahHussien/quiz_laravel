<?php

namespace App\Http\Controllers;

use App\Domains\Coupons\Exceptions\CouponCodeAlreadyExistsException;
use App\Domains\Coupons\Services\CouponsService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;


class CouponsController extends Controller
{
    protected $coupons_service; 

    public function __construct( 
        CouponsService $coupons_service,
     )
    {
        $this->coupons_service     = $coupons_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
 
            $data = $this->coupons_service->prepare_data_table();
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){
 
                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ="";
                        if(in_array('24/edit', $modules_ids) && !$row->used):
                            $btn .=' <a href="'.route('coupons.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('24/delete', $modules_ids) && !$row->used):
                            $btn .='<a href="'.route('coupons.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;
 
                    })
                    ->addColumn('status', function($row){
                        if($row->used){
                            $status = '<span class="badge bg-success">'.__('Used').'</span>';
                        }else{
                            $today = Carbon::today(); // Get today's date
                            if ($row->expires_at && Carbon::parse($row->expires_at)->isBefore($today)) {
                                $status = '<span class="badge bg-danger">'.__('Expired').'</span>';
                            }else{
                                $status = '<span class="badge bg-info">'.__('Active').'</span>';
                            }
                        }
                        return $status;
                    })
                    ->rawColumns(['status','actions'])
                    ->make(true);
            
        } 
       
        return view('coupons.coupons');
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
        $coupon = $this->coupons_service->get_instance();
        return view('coupons.coupons-form',compact('coupon'));
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $coupon = $this->coupons_service->create($request);
        } catch (\App\Domains\Coupons\Exceptions\CouponCodeAlreadyExistsException $e) {
            return response()->json(['message' => __($e->getMessage()),  'success' => false]);
        }
        return jsonResponse(['coupon'=>$coupon],200,__('Coupon created successfully'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validateCoupon(Request $request)
    {
        $discount = 0;
        try {
            $discount = $this->coupons_service->getCouponDiscount($request->coupon);
        } catch (\App\Domains\Coupons\Exceptions\CouponNotFoundException $e) {
            return response()->json(['message' => __($e->getMessage()),  'success' => false]);
        }

        return jsonResponse(['discount'=>$discount],200,__('Coupon is applied successfully'));

    }
 
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->coupons_service->find($id);
        if($model){
            $coupon = $this->coupons_service->entity_to_data_model($model);
            return view('coupons.coupons-form', compact('coupon'));
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
        $coupon = $this->coupons_service->update($id,$request);
        return jsonResponse(['coupon'=>$coupon],200,__('Coupon updated successfully'));
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = $this->coupons_service->find($id);
        if (!$coupon) {
            return response()->json(['message' => __('Coupon already deleted!'),  'success' => false]);
        } else {
             
            
            try {
                $this->coupons_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }
 
            return response()->json(['message' => __('Coupon has been deleted!'),  'success' => true]);
        }
 
        return back();
    }

}
