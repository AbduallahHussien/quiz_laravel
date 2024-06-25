<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Domains\Customers\Services\CustomersService; 
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $customers_service;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomersService $customers_service)
    {
        $this->customers_service       = $customers_service;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function showRegistrationForm()
    {
        $countries = $this->customers_service->countries();

        return View::make('auth.register', compact('countries'));
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'full_name' => ['required', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers','unique:vendors'],
            'phone' => ['required', 'numeric'],
            'country_id' => ['required'],
            'birth_date' => ['required', 'date'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        
       
    }
    public function register(Request $request)
    {
        if (isset($request['is_vendor'])) {
            DB::table('vendors')->insert([
                'full_name' => $request['full_name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'country_id' => $request['country_id'],
                'area' => $request['area'],
                'created_at'=>date('Y-m-d'),
                'password' => Hash::make($request['password']),
            ]);
            Session::flash('success', __('Thank you for registeration, your account is currently under review.'));
        } else {
            DB::table('customers')->insert([
                'full_name' => $request['full_name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'gender' => $request['gender'],
                'birth_date' => $request['birth_date'],
                'country_id' => $request['country_id'],
                'area' => $request['area'],
                'created_at'=>date('Y-m-d'),
                'password' => Hash::make($request['password']),
            ]);
            Session::flash('success', __('Your account is created successfully please login to access your profile'));

        }
         // Flash a success message to the session

        return redirect()->route('login');
    }


    
}
