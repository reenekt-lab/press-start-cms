@extends('system.admin_page.admin')

@section('title','Контент press-start-cms')

@section('sub_content')
    <div class="row">
        <div class="col-12">
            <div class="wrap_list_category">
                <div class="wrap_chain">
                    <a href="{{route('list_categories')}}">
                        Категории
                    </a>
                </div>
                <div class="wrap_title_category">
                    <p>
                        Категории
                    </p>
                    @if(Gate::allows('access_to_create'))
                        <div class="wrapBtnAddCategoryOrContent">
                            <a href="{{route('fromAddCategory')}}">
                                Добавить категорию
                            </a>
                            <a href="{{route('from_add_content',$id)}}">
                                Добавить контент
                            </a>
                        </div>
                    @endif
                </div>
                @if ($errors->any())
                    <div class="error_list">
                        <p class="title_error">
                            Ошибка:
                        </p>
                        @error('category_name')
                        <p>
                            {{$message}}
                        </p>
                        @enderror
                    </div>
                @endif
                <div class="row col_list_category">
                    <div class="col-1">
                        <input type="checkbox" class="main_checkbox_admin_page">
                    </div>
                    <div class="col-1">

                    </div>
                    <div class="col-4">
                        <p>
                            Название
                        </p>
                    </div>
                    <div class="col-4">
                        <p>
                            Активность
                        </p>
                    </div>
                    <div class="col-2">
                        <p>
                            ID
                        </p>
                    </div>

                    <div class="col-12">
                        <form method="post" action="{{route('actionList')}}">
                            @csrf
                            <!--Отображает список подкаегорий-->
                            @foreach($arSubCategory as $arItem)
                                <div class="row" style="display: flex;flex-wrap: wrap">
                                    <div class="col-1 list_category_tool">
                                        <input name="category_{{$arItem->id}}" class="row_checkbox" type="checkbox">
                                    </div>
                                    <div class="col-1 d-flex justify-content-center list_category_change_btn">
                                        <a href="{{route('update_category',$arItem->id)}}">
                                            <img class="btn_preloader" src="{{asset('system/img/another_img/pencil-edit.svg')}}" alt="change_btn">
                                        </a>
                                    </div>
                                    <div class="col-4 list_category_name categoryCol">
                                        <a href="{{route('list_sub_content',$arItem->id)}}">
                                            {{$arItem->name}}
                                        </a>
                                    </div>
                                    <div class="col-4 list_category_active">
                                        @if($arItem->active)
                                            <p>
                                                Активно
                                            </p>
                                        @else
                                            <p>
                                                Не активно
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-2 list_category_id">
                                        <p>
                                            {{$arItem->id}}
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                            <!--Отображает список контента-->

                            <!--Отображение списка контента-->
                            @foreach($arContent as $arItem)
                                    <div class="row" style="display: flex;flex-wrap: wrap">
                                        <div class="col-1 list_category_tool">
                                            <input name="content_{{$arItem->id}}" class="row_checkbox" type="checkbox">
                                        </div>
                                        <div class="col-1 d-flex justify-content-center list_category_change_btn">
                                            <a href="{{route('detail_content',[$id,$arItem->id])}}">
                                                <img class="btn_preloader" src="{{asset('system/img/another_img/pencil-edit.svg')}}" alt="change_btn">
                                            </a>
                                        </div>
                                        <div class="col-4 list_category_name">
                                            <a href="{{route('detail_content',[$id,$arItem->id])}}">
                                                {{$arItem->title}}
                                            </a>
                                        </div>
                                        <div class="col-4 list_category_active">
                                            @if($arItem->active)
                                                <p>
                                                    Активно
                                                </p>
                                            @else
                                                <p>
                                                    Не активно
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-2 list_category_id">
                                            <p>
                                                {{$arItem->id}}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach

                            @if($arSubCategory->count() || $arContent->count())
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
                                            <input class="btn btn-primary btn_preloader" type="submit" value="ПРИМЕНИТЬ">
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
