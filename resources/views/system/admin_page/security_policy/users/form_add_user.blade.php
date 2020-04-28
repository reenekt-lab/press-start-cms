@extends('system.admin_page.admin')

@section('from_add_user')
    <div class="row">
        <div class="col-12">
            <form class="form_user" method="post" action="{{route('add_user')}}">
                @csrf
                <div class="row">
                    <div class="col-8">
                        <div class="bg_detail">
                            <div class="wrap_chain">
                                @foreach($arChain as $key=>$value)
                                    <a
                                        @if($key=='/')
                                            href="{{route('admin_account')}}"
                                        @else
                                            href=""
                                        @endif
                                    >
                                        {{$value}}
                                    </a>
                                @endforeach
                            </div>
                            @if ($errors->any())
                                <div class="error_list">
                                    <p class="title_error">
                                        Ошибка:
                                    </p>
                                    @error('login')
                                    <p>
                                        {{$message}}
                                    </p>
                                    @enderror

                                    @error('email')
                                    <p>
                                        {{$message}}
                                    </p>
                                    @enderror
                                    @error('password')
                                    <p>
                                        {{$message}}
                                    </p>
                                    @enderror
                                    @error('select_role')
                                    <p>
                                        {{$message}}
                                    </p>
                                    @enderror
                                </div>
                            @endif
                            <div class="wrap_title_user_add">
                                <p>
                                    Добавление нового пользователя
                                </p>
                            </div>
                            <div class="wrap_login">
                                <p>
                                    Логин
                                </p>
                                <input name="login" type="text" value="{{old('login')}}">
                            </div>
                            <div class="wrap_email">
                                <p>
                                    Email
                                </p>
                                <input name="email" type="text" value="{{old('email')}}">
                            </div>
                            <div class="wrap_password">
                                <p>
                                    Пароль
                                </p>
                                <input name="password" type="password">
                            </div>
                            <div class="wrap_confirm_password">
                                <p>
                                    Потверждение пароля
                                </p>
                                <input name="password_confirmation" type="password">
                            </div>
                            <input class="btn btn-primary" type="submit" value="Добавить">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="wrap_choose_role">
                            <p>
                                Роль
                            </p>
                            <select name="select_role">
                                <option selected disabled></option>
                                @foreach($arRoles as $arItem)
                                    <option value="{{$arItem->id}}">{{$arItem->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
