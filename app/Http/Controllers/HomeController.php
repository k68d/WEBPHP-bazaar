<?php

namespace App\Http\Controllers;

use App\Models\Advertentie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() 
    {
        $advertenties = Advertentie::orderBy('updated_at', 'desc')->take(4)->get();

        return view('home', compact('advertenties'));
    }
}
