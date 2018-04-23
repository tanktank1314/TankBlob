<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{
    function __construct()
    {
        $this->middleware('guest',['only' => ['create']]);
    }

    public function create()
    {
        return view('login.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials,$request->has('remember'))) {
            session()->flash('success','登录成功！');
            return redirect()->route('users.show',[Auth::user()->id]);
        } else {
            session()->flash('danger','邮件或密码不匹配！');
            return redirect()->back();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success','退出成功！');
        return redirect()->route('login');
    }
}
