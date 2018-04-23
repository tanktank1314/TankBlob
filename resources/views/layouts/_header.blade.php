<header class="navbar navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="col-md-offset-1 col-md-10">
            <a href="{{ route('app.home') }}" id="logo">Tank 博客</a>
            <nav>
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="user-avatar pull-left" style="margin-right: 8px;margin-top: -5px;">
                                    <img src="{{ Auth::user()->getavatar('30') }}" class="img-responsive img-circle" width="30px" height="30px">
                                </span>
                                {{ Auth::user()->name }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('users.show',Auth::user()->id) }}">
                                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                        个人中心
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('users.edit',Auth::user()->id) }}">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                        编辑资料
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
                                        用户列表
                                    </a>
                                </li>

                                <li>
                                    <a id="logout" href="#">
                                        <form action="{{ route('login.destroy',Auth::user()->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-block btn-danger" type="submit" name="button">
                                                退出
                                            </button>
                                        </form>

                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ route('login.create') }}">登录</a></li>
                        <li><a href="{{ route('users.create') }}">注册</a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</header><!-- /header -->