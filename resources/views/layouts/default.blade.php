<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title','Web') - Tank博客</title>
    <link rel="stylesheet" href="">
</head>
<body>
    @include('layouts._header')
    @yield('content')
    @include('layouts._footer')
</body>
</html>