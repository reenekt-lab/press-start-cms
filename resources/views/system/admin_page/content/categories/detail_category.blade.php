@extends('system.admin_page.admin')

@section('detail_category')
<div class="row">
    <div class="col-12">
        <div class="bg_detail">
            <div class="wrap_chain">
                <a class="a_category" href="{{route('list_categories')}}">
                    Категории
                </a>
                <a class="a_detail" href="javascript:void(0)">
                    Редактирование категории
                </a>
                <a class="a_detail" href="javascript:void(0)">
                    {{$arCategory->name}}
                </a>
            </div>
            <div class="wrap_title_detail">
                <p>
                    Редактирование: {{$arCategory->name}}
                </p>
            </div>
            @if ($errors->any())
            <div class="error_list">
                <p class="title_error">
                    Ошибка:
                </p>
                @error('name_category')
                <p>
                    {{$message}}
                </p>
                @enderror
            </div>
            @endif
            <form class="add_content_from" method="post" action="{{route('update_category',$arCategory->id)}}">
                @csrf
                <div class="detail_active">
                    <p>
                        Активность:
                    </p>
                    <input type="checkbox" name="checkbox"
                       @if($arCategory->active)
                            checked
                        @endif>
                </div>
                <div class="user_creater detail_date_of_creation">
                    <p>
                        Запись создана пользователем: {{$arUser->login}}
                    </p>
                </div>
                <div class="detail_date_of_creation">
                    <p>
                        Создано: {{ date('d.m.Y', strtotime($arCategory->created_at))}}
                    </p>
                </div>
                <div>
                    <p class="add_content_title">
                        Название
                    </p>
                    <input name="name_category" type="text" value="{{old('name_category',$arCategory->name)}}">
                </div>
                @if(Gate::allows('access_to_edit'))
                <input class="btn btn-primary btn_preloader" type="submit" value="Сохранить">
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
