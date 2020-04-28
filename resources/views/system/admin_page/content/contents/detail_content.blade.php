@extends('system.admin_page.admin')

@section('detail_content')
    <div class="row">
        <div class="col-12">
            <div class="bg_detail">
                <div class="wrap_chain">
                    <a href="{{route('list_categories')}}">
                        Категории
                    </a>
                    <a href="{{route('list_sub_content',$id)}}">
                        Контент
                    </a>
                    <a href="javascript:void(0)">
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

                    @if($arSetAdditionalProperties!=null)
                        @php
                        $i=0;
                        @endphp
                        @foreach($arSetAdditionalProperties as $arItem)
                            <p class="add_content_title">
                                {{$arItem->name}}
                            </p>
                            @if($arItem->listAdditionalProperty->type=='input')
                                <!--Проверяем, есть ли у данного контента свойства с значением-->
                                @if(sizeof($arPropVal)>0 && isset($arPropVal[$i]))
                                    <input
                                        type="text"
                                        name="additionalProperty_{{$arItem->id}}"
                                        value="{{old('additionalProperty_'.$arItem->id,$arItem->id==$arPropVal[$i]->set_additional_prop_id?$arPropVal[$i]->value:'')}}"
                                    >
                                @else
                                    <input
                                        type="text"
                                        name="additionalProperty_{{$arItem->id}}"
                                        value="{{old('additionalProperty_'.$arItem->id)}}"
                                    >
                                @endif
                            @endif

                            @php
                                $i++
                            @endphp
                        @endforeach
                    @endif

                    @if(Gate::allows('access_to_edit'))
                    <input class="btn btn-primary btn_preloader" type="submit" value="Сохранить">
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
