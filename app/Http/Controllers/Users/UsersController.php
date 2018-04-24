<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Handlers\ImageUploadHandler;
use Auth;
use Mail;

class UsersController extends Controller
{
    function __construct()
    {
        $this->middleware('auth',['except' => ['create','store','show','index','confirmEmail']]);
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

        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect()->route('app.home');
        // Auth::login($user);
        // session()->flash('success','注册成功！');
        // return redirect()->route('users.show',[$user->id]);

    }

    protected function sendEmailConfirmationTo($user)
    {
        $view = 'confirms.email';
        $data = compact('user');
        $from = $user->email;
        $name = 'Tank';
        $to = $user->email;
        $subject = '感谢注册 Tank博客！请确认你的邮箱。';
        Mail::send($view,$data,function($message) use($from,$name,$to,$subject) {
            $message->from($from,$name)->to($to)->subject($subject);
        });
    }

    public function confirmEmail($token)
    {
        $user = User::where('activation_token',$token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success','激活成功！');
        return redirect()->route('users.show',[$user->id]);
    }

    public function show(User $user)
    {
        $statuses = $user->statuses_order_desc()
                         ->paginate(30);
        return view('users.show',compact('user','statuses'));
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

    public function followings(User $user)
    {
        $users = $user->followings()->paginate(30);
        $title = '关注的人';
        return view('users.follow',compact('users','title'));
    }

    public function followers(User $user)
    {
        $users = $user->followers()->paginate(30);
        $title = '粉丝';
        return view('users.follow',compact('users','title'));
    }
}
