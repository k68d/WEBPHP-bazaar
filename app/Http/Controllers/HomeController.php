<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;

class HomeController extends Controller
{
    public function index() 
    {
        $advertenties = Advertisement::orderBy('updated_at', 'desc')->take(4)->get();

        return view('home', compact('advertenties'));
    }
}
