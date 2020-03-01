@extends('system.admin_page.admin')

@section('title','Политика безопасности press-start-cms')

@section('admin_account')
    <div class="row">
        <div class="col-12">
            <div class="wrap_list_category">
                <div class="wrap_chain">
                    <a href="">
                        Список пользователей
                    </a>
                </div>
                <div class="wrap_title_category">
                    <p>
                        Список пользователей
                    </p>
                    @if(Gate::allows('access_to_create'))
                    <div>
                        <a class="btn btn-primary" href="{{route('form_user')}}">
                            Добавить пользователя
                        </a>
                    </div>
                    @endif
                </div>
                <div class="row col_list_category">
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <input type="checkbox" class="main_checkbox_admin_page">
                    </div>
                    <div class="col-3 d-flex align-items-center">
                        <p>
                            Логин
                        </p>
                    </div>
                    <div class="col-3 d-flex align-items-center">
                        <p>
                            Email
                        </p>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <p>
                            Активность
                        </p>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <p>
                            ID
                        </p>
                    </div>
                    <div class="col-12">
                        <form method="post" action="{{route('action_user')}}">
                            @csrf
                            @foreach($arResult as $arItem)
                                <div class="row row_border_top">
                                    <div class="col-2 d-flex justify-content-center align-items-center">
                                        <input name="checkbox_{{$arItem->id}}" class="row_checkbox" type="checkbox">
                                    </div>
                                    <div class="col-3 d-flex align-items-center">
                                        <a href="{{route('detail_user',$arItem->id)}}">
                                            {{$arItem->login}}
                                        </a>
                                    </div>
                                    <div class="col-3 d-flex align-items-center">
                                        {{$arItem->email}}
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        @if($arItem->active)
                                            Активно
                                        @else
                                            Неактивно
                                        @endif
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        {{$arItem->id}}
                                    </div>
                                </div>
                            @endforeach
                            @if($arResult->total() > $arResult->count())
                                <div class="wrap_pagination">
                                    {{ $arResult->links()  }}
                                </div>
                            @endif
                            @if($arResult->count())
                            <div class="col-12" style="padding: 0">
                                <div class="two_tags">
                                    <div class="select_tag">
                                        <select name="option_action" class="select">
                                            <option disabled selected > - ДЕЙСТВИЯ - </option>
                                            @if(Gate::allows('access_to_edit'))
                                            <option>Активировать</option>
                                            <option>Деактивировать</option>
                                            @endif
                                            @if(Gate::allows('access_to_delete'))
                                            <option>Удалить</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="input_tag">
                                        <input class="btn btn-primary" type="submit" value="ПРИМЕНИТЬ">
                                    </div>
                                </div>
                                <div class="disapled_two_tags"></div>
                            </div>
                        @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
