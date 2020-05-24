@extends('system.admin_page.admin')

@section('from_add_content')
    <div class="row">
        <div class="bg_detail">
            <div class="wrap_chain">
                <a href="{{route('list_categories')}}">
                    Категории
                </a>
                <a class="a_content" href="#">
                    Создание контента
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
            <form class="add_content_from" method="post" action="{{route('add_content',$id)}}">
                @csrf
                <p class="add_content_title">
                    Название
                </p>
                <input name="title" type="text" value="{{old('title')}}"> <br>
                <p>
                    Содержимое
                </p>
                <textarea name="content" id="editor" cols="30" rows="30">{{old('content')}}</textarea>

                @if($arSetAdditionalProperties!=null)
                    <div>
                        @foreach($arSetAdditionalProperties as $arItem)
                            <p class="add_content_title">
                                {{$arItem->name}}
                            </p>
                            @if($arItem->listAdditionalProperty->type=='input')
                                <input
                                    type="text"
                                    name="additionalPropValInput_{{$arItem->id}}"
                                    value="{{old('additionalProperty_'.$arItem->id,$arItem->defaultVal)}}"
                                >
                            @endif

                            @if($arItem->listAdditionalProperty->type=='textarea')
                                <textarea
                                    name="additionalPropertyTextArea_{{$arItem->id}}"
                                    cols="{{$arItem->width!=null? $arItem->width:30}}"
                                    rows="{{$arItem->height!=null? $arItem->height:5}}"
                                    style="resize: none"
                                >{{old('additionalPropertyTextArea_'.$arItem->id,$arItem->defaultVal)}}</textarea>
                            @endif
                        @endforeach
                    </div>
                @endif

                <input class="btn btn-primary btn_preloader" type="submit" value="Сохранить">
            </form>
        </div>
    </div>
@endsection
