@extends('layouts.default')
@section('title','编辑个人资料')
@section('content')
<div class="col-md-offset-2 col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5>编辑个人资料</h5>
        </div>
        <div class="panel-body">
            @include('layouts._errors')

            <form method="POST" action="{{ route('users.update',$user->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="form-group">
                    <label for="avatar" class="avatar-label">头像：</label>
                    <input type="file" name="avatar">
                    @if ($user->avatar)
                        <div class="avatar_edit">
                            <img class="thumbnail img-responsive avatar" src="{{ $user->getavatar('200') }}" alt="{{ $user->name }}" width="200px">
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">名称：</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                </div>

                <div class="form-group">
                    <label for="email">邮箱：</label>
                    <input type="text" name="email" class="form-control" value="{{ $user->email }}" disabled>
                </div>

                {{-- <div class="form-group">
                    <label for="password">密码：</label>
                    <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">确认密码：</label>
                    <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
                </div> --}}

                <button type="submit" class="btn btn-primary">更新</button>
            </form>
        </div>
    </div>
</div>
@stop