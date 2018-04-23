<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function home()
    {
        return view('app/home');
    }

    public function help()
    {
        return view('app/help');
    }

    public function about()
    {
        return view('app/about');
    }
}
