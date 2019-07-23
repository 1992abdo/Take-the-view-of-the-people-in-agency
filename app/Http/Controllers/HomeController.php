<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect('/dashbord/fr');
        // return view('home');
    }
        public  function dashbord($language){
            $langs = DB::table('langs')->get();
            session(['language' => "$language"]);
            $choiseLang= app()->setLocale($language);
            return view('dashbord.dashbord',compact('langs','language'));   
        }
    
}