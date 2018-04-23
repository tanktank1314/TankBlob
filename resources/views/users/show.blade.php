@extends('layouts.default')
@section('title',$user->name)
@section('content')
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="col-md-12">
                <div class="col-md-offset-2 col-md-8">
                    <section class="user_info">
                        @include('users._user_info',['user' => $user])
                    </section>
                </div>
            </div>
            <div class="col-md-12">
                @include('statuses._statuses')
            </div>
        </div>
    </div>
@stop