@extends('system.admin_page.admin')

@section('title','Дополнительные поля')

@section('settingListSuperCategories')
    <div class="row">
        <div class="col-12">
            <div class="wrap_list_category">
                <div class="wrap_chain">
                    <a href="{{route('setting_list_main_category')}}">
                        Список главных категорий
                    </a>
                </div>
                <div class="row col_list_category">
                    <div class="col-8">
                        <p>
                            Название
                        </p>
                    </div>
                    <div class="col-4">
                        <p>
                            ID
                        </p>
                    </div>
                    <div class="col-12">
                        <!--Отображает список главных категорий-->
                        @foreach($arCategory as $arItem)
                            <div class="row" style="display: flex;flex-wrap: wrap">
                                <div class="col-8 list_category_name categoryCol">
                                    <a href="{{route('display_form_add_property',$arItem->id)}}">
                                        {{$arItem->name}}
                                    </a>
                                </div>
                                <div class="col-4 list_category_id">
                                    <p>
                                        {{$arItem->id}}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
