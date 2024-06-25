<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\User\Services\UserService;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
class HomeController extends Controller
{


 
    public function __construct(UserService $user_service)
    {
        $this->user_service       = $user_service;
        $this->middleware('auth');

    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        return view('home');
    }
    public function profile(){
        $user = auth()->user();
       return $user->full_name;
    }
}
