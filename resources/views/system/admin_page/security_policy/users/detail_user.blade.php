@extends('system.admin_page.admin')

@section('detail_user')
    <div class="row">
        <div class="col-12">
            <form class="form_user" method="post" action="{{route('update_user',$arUser->id)}}">
                <input type="text" name="main_user" style="display: none" value="{{$arUser->main_user}}">
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
                                    Редактирования пользователя: {{$arUser->login}}
                                </p>
                            </div>
                            <div class="detail_active">
                                <p>
                                    Активность:
                                </p>
                                <input type="checkbox" name="checkbox"
                                       @if($arUser->active)
                                           checked
                                        @endif

                                        @if($arUser->main_user)
                                            disabled
                                            checked
                                        @endif
                                    >
                            </div>
                            <div class="wrap_login">
                                <p>
                                    Логин
                                </p>
                                <input name="login" type="text" value="{{old('login',$arUser->login)}}">
                            </div>
                            <div class="wrap_email">
                                <p>
                                    Email
                                </p>
                                <input name="email" type="text" value="{{old('email',$arUser->email)}}">
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
                            @if(Gate::allows('access_to_edit'))
                            <input class="btn btn-primary btn_preloader" type="submit" value="Сохранить">
                            @endif
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="wrap_choose_role">
                            <p>
                                Роль
                            </p>
                            {{--
                                Пользователю, которого указывали, при регистрации нельзя менять роль.
                                Т.к. если ему поменять роль, то он не сможет заходить в админку.
                            --}}
                            <select name="select_role" @if($arUser->main_user) disabled @endif>
                                <option selected disabled></option>
                                @foreach($arRole as $arItem)
                                    {{--Чтобы выбранную роль отображалось в списке после загрузки DOM--}}
                                    @if($arItem->name==$arUser->roles()->first()->name))
                                        <option selected value="{{$arItem->id}}">{{$arItem->name}}</option>
                                    @else
                                        <option value="{{$arItem->id}}">{{$arItem->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
