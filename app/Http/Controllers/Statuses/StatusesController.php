<?php

namespace App\Http\Controllers\Statuses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Status;

class StatusesController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'content' => 'required|max:140',
        ]);

        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);

        return redirect()->back();
    }

    public function destroy(Status $status)
    {
        $this->authorize('destroy',$status);

        $status->delete();
        session()->flash('success','删除成功！');
        return redirect()->back();
    }
}
