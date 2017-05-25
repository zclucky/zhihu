<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function test(){
        $email = "myxxqy@gmail.com";
        $hash = md5(strtolower(trim($email)));
        $url = "http://www.gravatar.com/avatar/$hash?s=100";
        return $url;
    }
}
