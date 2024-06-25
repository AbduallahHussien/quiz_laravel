<?php

namespace App\Http\Controllers\Public;

use App\Domains\Customers\Services\CustomersService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\SalesOrders\Services\SalesOrdersService; 
use App\Domains\Customers\Services\AddressesService; 
use App\Domains\Coupons\Services\CouponsService;
use App\Domains\Paintings\Services\PaintingsService;
use Illuminate\Support\Facades\Auth;


use Carbon\Carbon;


class CheckoutController extends Controller
{

    protected $orders_service; 
    protected $customers_service;
    protected $coupons_service;
    protected $paintings_service;
    protected $addresses_service;

    public function __construct( 
        SalesOrdersService $orders_service, 
        CustomersService $customers_service,
        CouponsService $coupons_service,
        PaintingsService $paintings_service,
        AddressesService $addresses_service,
    )

    {
        $this->orders_service       = $orders_service;
        $this->customers_service    = $customers_service;
        $this->coupons_service      = $coupons_service;
        $this->paintings_service    = $paintings_service;
        $this->addresses_service    = $addresses_service;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billing_address = $shipping_address = $this->addresses_service->get_instance();
        if(!Auth::check() || Auth::guard('customer')->check()){
            $paintings =  $this->paintings_service->cart();
            $countries = $this->customers_service->countries();
            if(Auth::guard('customer')->check()){
                $customer_id = Auth::guard('customer')->id();
                $billing_address = $this->addresses_service->getCustomerAddress('billing', $customer_id); 
                $shipping_address = $this->addresses_service->getCustomerAddress('shipping', $customer_id); 
            }
            return view('public.checkout',compact('countries','paintings','billing_address','shipping_address'));
        }else{
            abort(404);
        }

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
        $discount = 0;
        //check if coupon is set 
        if($request->coupon){
            //if is set validate it and get discount
            //if not valid return an error
            try {
                $discount = $this->coupons_service->getCouponDiscount($request->coupon);
            } catch (\App\Domains\Coupons\Exceptions\CouponNotFoundException $e) {
                return response()->json(['message' => __($e->getMessage()),  'success' => false]);
            }
        }

        //validate the availability of paintings else return error
        try {
            $paintings = $this->paintings_service->getPaintingsData(json_decode($request->paintings));
        } catch (\App\Domains\Paintings\Exceptions\PaintingNotFoundException $e) {
            return response()->json(['message' => __($e->getMessage()),  'success' => false]);
        }
        
        $billing_address = json_decode($request->billing_address, true);
        $shipping_address = $request->shipping_address ? json_decode($request->shipping_address , true):false; 
        //get customer id
        $customer_id = Auth::guard('customer')->id();
        //if not logged in
        if(!$customer_id){
            //create customer and logged him in
            try {
                $customer = $this->customers_service->createFromBillingAddress($billing_address);
            } catch (\App\Domains\Customers\Exceptions\EmailIsAlreadyUsedException $e) {
                return response()->json(['message' => __($e->getMessage()),  'success' => false]);
            }

            
        }else{
            $customer = $this->customers_service->find($customer_id);
        }

        $billing_address = $this->addresses_service->updateCustomerBillingAddress($customer->id,$billing_address);

        // //check if shipping address is not empty
        if($shipping_address){
            //if not empty create shipping address
           $shipping_address = $this->addresses_service->createShippingAddress($customer->id, $shipping_address);
        }else{
            $shipping_address = $billing_address;
        }

        //calc totals and create sales order
        try {
            $order = $this->orders_service->proccessCustomerOrder(
                $paintings,
                $customer->id,
                $shipping_address,
                $request->coupon,
                $request->notes,
                $discount
             );
        } catch (\Exception $e) {
            return response()->json(['message' => __($e->getMessage()),  'success' => false]);
        }

        $this->coupons_service->markCouponAsUsedByCode($request->coupon);
        $this->paintings_service->emptyCart();
        return response()->json(['message' => __('Order created successfully'),  'success' => true, 'order_id' => $order->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function thankYou($id)
    {
        $order = $this->orders_service->find($id);
        if($order){
            return view('public.thank-you', compact('order'));
        }else{
            abort(404);
        }


    }

}
