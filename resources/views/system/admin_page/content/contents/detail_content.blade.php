@extends('system.admin_page.admin')

@section('detail_content')
    <div class="row">
        <div class="col-12">
            <div class="bg_detail">
                <div class="wrap_chain">
                    <a class="a_category" href="{{route('list_categories')}}">
                        Категории
                    </a>
                    <a class="a_content detail_content" href="{{route('list_content',$id)}}">
                        Контент
                    </a>
                    <a class="a_detail a_content a_category" href="javascript:void(0)">
                        Редактирование
                    </a>
                    <a class="a_detail" href="javascript:void(0)">
                        {{$arContent->title}}
                    </a>
                </div>
                @if ($errors->any())
                    <div class="error_list">
                        <p class="title_error">
                            Ошибка:
                        </p>
                        @error('title')
                        <p>
                            {{$message}}
                        </p>
                        @enderror

                        @error('content')
                        <p>
                            {{$message}}
                        </p>
                        @enderror
                    </div>
                @endif
                <form class="add_content_from" method="post" action="{{route('update_detail',[$id,$arContent->id])}}">
                    @csrf
                    <div class="detail_active">
                        <p>
                            Активность:
                        </p>
                        <input type="checkbox" name="checkbox"
                           @if($arContent->active)
                               checked
                            @endif>
                    </div>
                    <div class="user_creater detail_date_of_creation">
                        <p>
                            Запись создана пользователем:
                            @if(!empty($user->login))
                                {{$user->login}}
                            @else
                                удален
                            @endif
                        </p>
                    </div>
                    <div class="detail_date_of_creation">
                        <p>
                            Создано: {{ date('d.m.Y', strtotime($arContent->created_at))}}
                        </p>
                    </div>
                    <div>
                        <p class="add_content_title">
                            Название
                        </p>
                        <input name="title" type="text" value="{{old('title',$arContent->title)}}">
                    </div>
                    <p class="add_content_content">
                        Содержимое
                    </p>
                    <textarea name="content" id="editor">
                        {{old('content',$arContent->content)}}
                    </textarea>
                    <input class="btn btn-primary btn_preloader" type="submit" value="Сохранить">
                </form>
            </div>
        </div>
    </div>
@endsection
