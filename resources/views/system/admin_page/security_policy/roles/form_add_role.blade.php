@extends('system.admin_page.admin')

@section('from_add_role')
    <div class="row">
        <div class="col-12">
            <form class="form_user" method="post" action="{{'add_role'}}">
                @csrf
                <div class="row">
                    <div class="col-8">
                        <div class="bg_detail">
                            <div class="wrap_chain">
                                <a class="a_category" href="{{route('all_roles')}}">Список ролей</a>
                                <a href="javascript:void(0)">Добавление роли</a>
                            </div>
                            @if ($errors->any())
                                <div class="error_list">
                                    <p class="title_error">
                                        Ошибка:
                                    </p>
                                    @error('nameRole')
                                    <p>
                                        {{$message}}
                                    </p>
                                    @enderror
                                </div>
                            @endif
                            <div class="wrap_title_user_add">
                                <p>
                                    Добавление новой роли
                                </p>
                            </div>
                            <div class="wrap_login">
                                <p>
                                    Название роли
                                </p>
                                <input name="nameRole" type="text" value="{{old('nameRole')}}">
                            </div>
                            <input class="btn btn-primary btn_preloader" type="submit" value="Добавить">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="wrap_choose_role">
                            <p>
                                Права
                            </p>
                            <div class="wrap_access_points">
                                <input name="access_admin_page" type="checkbox" id="checkbox-id-2" />
                                <label for="checkbox-id-2">
                                    Доступ к админ странице
                                </label>
                            </div>
                            <div class="wrap_access_points">
                                <input name="access_content" type="checkbox" id="checkbox-id-3" />
                                <label for="checkbox-id-3">
                                    Доступ к контенту
                                </label>
                            </div>
                            <div class="wrap_access_points">
                                <input name="access_security_policy" type="checkbox" id="checkbox-id-4" />
                                <label for="checkbox-id-4">
                                    Доступ к политике безопасноси
                                </label>
                            </div>
                            <div class="wrap_access_points">
                                <input name="access_setting" type="checkbox" id="checkbox-id-5" />
                                <label for="checkbox-id-5">
                                    Доступ к настройкам
                                </label>
                            </div>
                            <div class="wrap_access_points">
                                <input name="access_to_create" type="checkbox" id="checkbox-id-6" />
                                <label for="checkbox-id-6">
                                    Возможность создавать
                                </label>
                            </div>
                            <div class="wrap_access_points">
                                <input name="access_to_edit" type="checkbox" id="checkbox-id-7" />
                                <label for="checkbox-id-7">
                                    Возможность редактировать
                                </label>
                            </div>
                            <div class="wrap_access_points">
                                <input name="access_to_delete" type="checkbox" id="checkbox-id-8" />
                                <label for="checkbox-id-8">
                                    Возможность удалять
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
