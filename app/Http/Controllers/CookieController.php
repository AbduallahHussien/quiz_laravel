<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CookieController extends Controller
{
    public function setCookie(Request $request) {
      
            $expires = time() + 60 * 60 * 24 * 365;
            $response = new Response('Hello World');
            $response->withCookie(cookie('sidebar-status', $request->status,$expires));
            return $response;
         
           
         
       

     }
     public function getCookie(Request $request) {
        $data = $request->cookie('sidebar-status');
         return $data;
     }
}
