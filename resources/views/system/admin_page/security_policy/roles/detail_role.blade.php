@extends('system.admin_page.admin')

@section('detail_role')
    <div class="row">
        <div class="col-12">
            <form class="form_user" method="post" action="{{route('update_role',$role->id)}}">
                @csrf
                <div class="row">
                    <div class="col-8">
                        <div class="bg_detail">
                            <div class="wrap_chain">
                                <a href="{{route('all_roles')}}">Список ролей</a>
                                <a href="javascript:void(0)">{{$role->name}}</a>
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
                                <input name="nameRole" type="text" value="{{old('nameRole',$role->name)}}">
                            </div>
                            @if(Gate::allows('access_to_edit'))
                            <input class="btn btn-primary btn_preloader" type="submit" value="Сохранить">
                            @endif
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="wrap_choose_role">
                            <p>
                                Права
                            </p>
                            <div class="wrap_access_points">
                                <input name="access_admin_page" type="checkbox" id="checkbox-id-2"
                                    @if($role->access_admin_page)
                                        checked
                                    @endif
                                />
                                <label for="checkbox-id-2">
                                    Доступ к админ странице
                                </label>
                            </div>
                            <div class="wrap_access_points">
                                <input name="access_content" type="checkbox" id="checkbox-id-3"
                                   @if($role->access_content)
                                       checked
                                    @endif
                                />
                                <label for="checkbox-id-3">
                                    Доступ к контенту
                                </label>
                            </div>
                            <div class="wrap_access_points">
                                <input name="access_security_policy" type="checkbox" id="checkbox-id-4"
                                   @if($role->access_security)
                                       checked
                                    @endif
                                />
                                <label for="checkbox-id-4">
                                    Доступ к политике безопасноси
                                </label>
                            </div>
                            <div class="wrap_access_points">
                                <input name="access_setting" type="checkbox" id="checkbox-id-5"
                                   @if($role->access_setting)
                                       checked
                                    @endif
                                />
                                <label for="checkbox-id-5">
                                    Доступ к настройкам
                                </label>
                            </div>
                            <div class="wrap_access_points">
                                <input name="access_to_create" type="checkbox" id="checkbox-id-6"
                                   @if($role->access_to_create)
                                       checked
                                    @endif
                                />
                                <label for="checkbox-id-6">
                                    Возможность создавать
                                </label>
                            </div>
                            <div class="wrap_access_points">
                                <input name="access_to_edit" type="checkbox" id="checkbox-id-7"
                                   @if($role->access_to_edit)
                                       checked
                                    @endif
                                />
                                <label for="checkbox-id-7">
                                    Возможность редактировать
                                </label>
                            </div>
                            <div class="wrap_access_points">
                                <input name="access_to_delete" type="checkbox" id="checkbox-id-8"
                                   @if($role->access_to_delete)
                                       checked
                                    @endif
                                />
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
