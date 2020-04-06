@extends('system.layouts.app')

@section('title','Главное press-start-cms')

@section('admin_page')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 d-flex flex-row" style="padding: 0;">
                <div class="admin_sidebar_panel">
                    <ul>
                        <li>
                            <a class="link_admin_page link_admin_page_home @if(Route::current()->getName()=='admin_main') selected_home_admin_page selected_admin_point @endif" href="{{route('admin_main')}}">
                                <div class="admin_main">
                                    Главное
                                </div>
                            </a>
                        </li>
                        @if(Gate::allows('access_content'))
                        <li>
                            <div class="admin_content link_admin_page link_admin_page_content
                                     @if(Route::current()->getName()=='list_categories' ||
                                        Route::current()->getName()=='list_content'     ||
                                        Route::current()->getName()=='update_category'     ||
                                        Route::current()->getName()=='from_add_content')
                                        selected_content_admin_page
                                    @endif">
                                Контент
                            </div>
                            <ul class="spisok_admin_content
                                    @if(Route::current()->getName()=='list_categories' ||
                                        Route::current()->getName()=='list_content'    ||
                                        Route::current()->getName()=='from_add_content'||
                                        Route::current()->getName()=='update_category' ||
                                        Route::current()->getName()=='detail_content')
                                        display_submenu_admin_content
                                    @endif">
                                <li>
                                    <a href="{{route('list_categories')}}" class="
                                        @if(Route::current()->getName()=='list_categories' ||
                                            Route::current()->getName()=='list_content'    ||
                                            Route::current()->getName()=='from_add_content'||
                                            Route::current()->getName()=='update_category' ||
                                            Route::current()->getName()=='detail_content')
                                            font_color
                                        @endif">
                                        Категории
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if(Gate::allows('access_security'))
                        <li>
                            <div class="admin_account link_admin_page link_admin_page_security" style="color: #959595">
                                Политка безопасности
                            </div>
                            <ul class="submenu_security_ul
                                @if(Route::current()->getName()=='admin_account' ||
                                    Route::current()->getName()=='form_user'     ||
                                    Route::current()->getName()=='detail_user'   ||
                                    Route::current()->getName()=='all_roles'     ||
                                    Route::current()->getName()=='detail_role')
                                    display_submenu_security_ul
                                @endif
                                ">
                                <li>
                                    <a href="{{route('admin_account')}}" class="
                                        list_user
                                        @if(Route::current()->getName()=='admin_account' ||
                                            Route::current()->getName()=='form_user'     ||
                                            Route::current()->getName()=='detail_user')
                                        font_color
                                        @endif">
                                        Список пользователей
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('all_roles')}}" class="
                                    list_roles
                                        @if(Route::current()->getName()=='all_roles' ||
                                            Route::current()->getName()=='detail_role')
                                        font_color
                                        @endif
                                        ">
                                        Список ролей
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if(Gate::allows('access_setting'))
                        <li>
                            <a href="{{route('admin_setting')}}" class="link_admin_page link_admin_page_setting
                                @if(Route::current()->getName()=='admin_setting')
                                    click
                                    selected_setting_amin_page
                                @endif">
                                <div class="setting">
                                    Настройки
                                </div>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-10">
                <div class="admin_another">
                    @yield('admin_main')

                    {{--content point admin pge--}}
                    @yield('admin_content')
                    @yield('category_list')
                    @yield('detail_category')
                    @yield('form_add_category')
                    @yield('sub_content')

                    @yield('list_contents')
                    @yield('from_add_content')
                    @yield('detail_content')

                    {{--security point admin page--}}
                    @yield('from_add_user')
                    @yield('detail_user')

                    @yield('list_roles')
                    @yield('from_add_role')
                    @yield('detail_role')

                    @yield('admin_account')
                    @yield('admin_setting')
                </div>
            </div>
        </div>
    </div>

    {{--preloader--}}
    <div class="bg_fix_preloader">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>
@endsection
