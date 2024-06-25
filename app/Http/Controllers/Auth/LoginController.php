<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->route('login');
    }
    public function email(){
        return 'email';
    }


// public function login(Request $request)
// {
//    

//     if (Auth::attempt($credentials, $remember)) {
//         // Authentication successful
//         return redirect()->intended('/admin');
//     } else {
//         // Authentication failed
//         return back()->withErrors([
//             'email' => 'Invalid credentials',
//         ]);
//     }
// }
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember'); // Check if the remember checkbox is checked
    if (Auth::guard('customer')->attempt($credentials)) {
        if(isset($request->from_checkout) ){
            return redirect()->intended('/checkout');

        }
        // Authentication passed for customer
        return redirect()->intended('/');
    }

    if (Auth::guard('vendor')->attempt($credentials)) {
        // Authentication passed for vendor
    
        $vendor = Auth::guard('vendor')->user();
        
        if ($vendor->status === 'pending') {
            return redirect()->intended('/vendor');
        }else
        if($vendor->status === 'rejected'){
            // Set the warning message
            Session::flash('danger', __('Your account is rejected!'));
                        
            // Logout the vendor and redirect to the login page
            Auth::guard('vendor')->logout();
            return redirect()->route('login');
        }else{
            // Redirect to the intended page
            return redirect()->intended('/vendor');
        }
    
       
    }
    if (Auth::guard('web')->attempt($credentials, $remember)) {
        // User authentication successful
        return redirect()->intended('/admin');
    } 
        // Authentication failed
        return back()->withErrors([
                        'email' => 'Invalid credentials',
                    ]);
    

}



}

