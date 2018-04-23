<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Status;

class AppController extends Controller
{
    public function home(Status $status)
    {
        // $statuses = [];
        // if (Auth::check()) {
        //     $statuses = Auth::user()->statuses_order_desc()->paginate(30);
        // }
        $statuses = $status->order_desc()->paginate(30);
        return view('app/home',compact('statuses'));
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
