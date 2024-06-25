<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use hash;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         // Register a custom Blade directive
            \Blade::if('routeExists', function ($routeName) {
                return Route::has($routeName);
            });
            Schema::defaultStringLength(191);
            Date::setLocale(app()->getLocale());
            Paginator::useBootstrap();
            try{
                view()->composer('*', function ($view) {
        
                    if (Auth::guard('customer')->check()) {
                        
                        \Session::put('customer_id',  Auth::guard('customer')->user()->id);
                        \Session::put('customer_type','user');
        
                        $customer_id = \Session::get('customer_id');
                        $customer_type =  \Session::get('customer_type'); 
                    }else {
                        
                        if ( \Session::get('customer_id')){
                            
                            $customer_id = \Session::get('customer_id');
                            $customer_type = \Session::get('customer_type'); 
        
                        }else{
        
                            \Session::put('customer_id',  rand(1231,9999));
                            \Session::put('customer_type','visitor');
        
                            $customer_id = \Session::get('customer_id');
                            $customer_type = \Session::get('customer_type'); 
                            
                        }
        
                    }
                    
                    $data_wishlist = \DB::select('SELECT painting_id  FROM wishlist WHERE customer_id ='.$customer_id.' ');
                    $data_cart = \DB::select('SELECT painting_id  FROM cart WHERE customer_id ='.$customer_id.' ');
        
                    $view->with('customer_id', \Session::get('customer_id') );  
                    $view->with('customer_type', \Session::get('customer_type') );
        
                    if( $data_wishlist &&  $data_wishlist!=''){
                        $wishlist = array();
                        foreach($data_wishlist as $row){
                            $wishlist[]= $row->painting_id;
                        }
                        $view->with('wishlist', $wishlist );   
        
                    }else{
                        $view->with('wishlist', $data_wishlist );   
                    } 
                    if( $data_cart &&  $data_cart!=''){
                        $cart = array();
                        foreach($data_cart as $row){
                            $cart[]= $row->painting_id;
                        }
                        $view->with('cart', $cart );   
        
                    }else{
                        $view->with('cart', $data_cart );   
                    } 
                }); 
          
              
           
            
            }catch (Throwable $th) {
                   return ;
            }

     
    }
}
