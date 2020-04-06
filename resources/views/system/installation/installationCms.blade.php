@extends('system.layouts.app')

@section('installation')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Установка CMS
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                @error('wrong_login_or_password')
                                <div class="wrap_error_installation">
                                    <p>
                                        {{$message}}
                                    </p>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <form method="POST" action="{{route('setSettingDb')}}">
                            @csrf
                            <div class="row input_installation">
                                <div class="col-md-5 d-flex justify-content-end mb-2 title_installation">
                                    <p>
                                        Сервер базы данных (по умолчанию localhost или 127.0.0.1)
                                    </p>
                                </div>
                                <div class="col-md-6 mb-2 input_installation">
                                    @error('db_host')
                                    <p>
                                        {{$message}}
                                    </p>
                                    @enderror
                                    <input name="db_host" type="text" class="input_installation"
                                           value="{{old('db_host')}}">
                                </div>
                                <div class="col-md-5 d-flex justify-content-end mb-2 title_installation">
                                    <p>
                                        Порт для подключения к БД (по умолчанию 3306)
                                    </p>
                                </div>
                                <div class="col-md-6 mb-2 input_installation">
                                    @error('db_host')
                                    <p>
                                        {{$message}}
                                    </p>
                                    @enderror
                                    <input name="db_port" type="text" class="input_installation"
                                           value="{{old('db_port')}}">
                                </div>
                                <div class="col-md-5 d-flex justify-content-end mb-2 title_installation">
                                    <p>
                                        Название базы данных
                                    </p>
                                </div>
                                <div class="col-md-6 mb-2 input_installation">
                                    @error('name_db')
                                    <p>
                                        {{$message}}
                                    </p>
                                    @enderror
                                    <input name="name_db" type="text" class="input_installation" value="{{old('name_db')}}">
                                </div>
                                <div class="col-md-5 d-flex justify-content-end mb-2">
                                    <p>
                                        Имя пользователя базы данных
                                    </p>
                                </div>
                                <div class="col-md-6 mb-2 input_installation">
                                    @error('login_db')
                                    <p>
                                        {{$message}}
                                    </p>
                                    @enderror
                                    <input name="login_db" type="text" class="input_installation">
                                </div>
                                <div class="col-md-5 d-flex justify-content-end mb-4">
                                    <p>
                                        Пароль
                                    </p>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <input name="db_password" type="password" class="input_installation"
                                           value="{{old('db_username')}}">
                                </div>
                            </div>

                            {{--Кнопка--}}
                            <div class="form-group row mb-0">
                                <div class="col-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary btn_preloader">
                                        Установить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--preloader--}}
    <div class="bg_fix_preloader">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
@endsection
