@extends('admin_page.admin')

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
                    <a class="a_detail" href="javascript:void(0)">
                        {{$arContent->title}}
                    </a>
                </div>
                <div class="wrap_title_detail">
                    <p>
                        Редактирование: {{$arContent->title}}
                    </p>
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
                            @endif
                        >
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
                    <input class="btn btn-primary" type="submit" value="Сохранить">
                </form>
            </div>
        </div>
    </div>
@endsection
