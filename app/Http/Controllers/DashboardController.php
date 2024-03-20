<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            return view('dashboards.admin');
        } elseif ($user->hasRole('Business')) {
            return view('dashboards.business');
        } elseif ($user->hasRole('Private')) {
            return view('dashboards.private');
        } else {
            return view('dashboards.standard');
        }
    }
}
