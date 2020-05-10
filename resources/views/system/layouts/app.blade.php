<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

{{--    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />--}}
    <script defer src="{{ mix('js/app.js') }}"></script>

    <!-- Plugins external assets -->
    {!! (new \App\Library\PluginManagers\ExternalAsset\ExternalAssetPluginManager)->renderInsideHead() !!}

    {!! Helper::systemSet() !!}

</head>
    <body>
        {{--отображение меню для перехода в админку--}}
        @include(\App\Helpers\Helper::getAdminMenu())

        {{--Регистрация--}}
        @yield('registrationForm')

        {{--Авторизация--}}
        @yield('loginForm')

        <!--Админка-->
        @yield('admin_page')

        @yield('content')

        {{--Если нет тем--}}
        @yield('null_template')

        {{--установка бд--}}
        @yield('installation')


        <!-- Plugins external assets -->
        {!! (new \App\Library\PluginManagers\ExternalAsset\ExternalAssetPluginManager)->renderInEdnOfBody() !!}

        {{--vue.js--}}
    </body>
</html>
