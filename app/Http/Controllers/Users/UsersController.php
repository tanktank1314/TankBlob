<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    function __construct()
    {
        $this->middleware('auth',['except' => ['create','store','show','index']]);
        $this->middleware('guest',['only' => ['create']]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>bcrypt($request->password),
        ]);

        Auth::login($user);
        session()->flash('success','注册成功！');
        return redirect()->route('users.show',[$user->id]);
    }

    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update',$user);

        return view('users.edit',compact('user'));
    }

    public function update(User $user,ImageUploadHandler $uploader,Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'required|confirmed|min:6',
            'avatar' => 'mimes:jpeg,bmp,png,gif,jpg|dimensions:min_width=200,min_height=200',
        ]);

        $this->authorize('update',$user);

        $data = $request->all();

        $data['password'] = bcrypt($request['password']);

        if ($request->avatar) {
            $result = $uploader->save($request->avatar,'avatars',$user->id);
            if($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);

        session()->flash('success','更新成功！');
        return redirect()->route('users.show',[$user->id]);
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy',$user);

        $user->delete();
        session()->flash('success','删除成功！');
        return redirect()->back();
    }

}
