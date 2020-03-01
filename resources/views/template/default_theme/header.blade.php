<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    {!! Helper::systemSet() !!}
    <link rel="stylesheet" href="{{asset('css/blog_style.css')}}">

</head>
<body>

{{--Подключение админки--}}
@include(Helper::getAdminMenu())

<header>
    <div class="container">
        {{--Верхняя херня--}}
        <div class="row top_row">
            <div class="col-md-12 d-flex justify-content-center align-items-center">
                <p class="text_title">
                    Large
                </p>
            </div>
        </div>
    </div>
</header>

@yield('content')

@include(Helper::usingTheme('footer'))

</body>
</html>
