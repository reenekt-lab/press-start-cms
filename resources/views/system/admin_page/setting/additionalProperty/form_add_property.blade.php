@extends('system.admin_page.admin')

@section('title','Дополнительные свойства')

@section('formAddProperty')
    <div class="row rowListAdditionalProperty">
        <p ref="hiddenListPropertyName" style="display: none">
            @foreach($arAdditionalProperty as $arItemProperty)
                {{$arItemProperty['name']}}|
            @endforeach
        </p>

        <p ref="hiddenListPropertyId" style="display: none">
            @foreach($arAdditionalProperty as $arItemProperty)
                {{$arItemProperty['id']}}|
            @endforeach
        </p>

        @if ($errors->any())
            <div class="error_list">
                <p class="title_error">
                    Ошибка:
                </p>
                <p>
                    @error('nameProp')
                    {{$message}}
                    @enderror
                </p>
                <p>
                    @error('symbolCodeUnique')
                    {{$message}}
                    @enderror
                </p>
                <p>
                    @error('russiaWord')
                    {{$message}}
                    @enderror
                </p>
            </div>
        @endif
        <div class="col-12">
            <div class="wrap_list_category">
                <div class="wrap_chain">
                    @foreach($arChain as $key=>$value)
                        <a
                            @if($key=='/')
                                href="{{route('setting_list_main_category')}}"
                            @else
                                href=""
                            @endif
                        >
                            {{$value}}
                        </a>
                    @endforeach
                </div>
                <div class="row rowTitleListProperty">
                    <div class="col-md-3 colTitleListProperty">
                        <p>
                            Название
                        </p>
                    </div>
                    <div class="col-md-3 colTitleListProperty">
                        <p>
                            Тип свойства
                        </p>
                    </div>
                    <div class="col-md-1 colTitleListProperty">
                        <p>
                            Активно
                        </p>
                    </div>
                    <div class="col-md-3 colTitleListProperty">
                        <p>
                            Символьный код
                        </p>
                    </div>
                    <div class="col-md-1 colTitleListProperty">
                        <p>
                            ID
                        </p>
                    </div>
                    <div class="col-md-1 colTitleListProperty">
                        <p>
                            Удалить
                        </p>
                    </div>
                </div>
                <form method="post" action="{{route('add_property',$id)}}">
                    @csrf
                    @php
                        $i=0;
                    @endphp
                    @foreach($arSetAdditionalProperty as $arItem)
                    <div class="row rowListProperty">
                        <div class="col-md-3 colListProperty">
                            <input type="text" name="propertyName_{{$arItem['id']}}" value="{{old('propertyName_'.$arItem['id'],$arItem['name'])}}">
                        </div>
                        <div class="col-md-3 colListProperty">
                            @if(array_key_exists('listProperties_'.$arItem['id'],old()))
                                <select name="listProperties_{{$arItem['id']}}">
                                    @foreach($arAdditionalProperty as $arItemProperty)
                                        <option value="{{$arItemProperty['id']}}"
                                            @if(old('listProperties_'.$arItem['id'])==$arItemProperty['id'])
                                                selected
                                            @endif>
                                            {{$arItemProperty['name']}}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <select name="listProperties_{{$arItem['id']}}">
                                    @foreach($arAdditionalProperty as $arItemProperty)
                                        <option value="{{$arItemProperty['id']}}"
                                                @if($arSetAdditionalProperty[$i]->property_id==$arItemProperty['id'])
                                                selected
                                            @endif
                                        >
                                            {{$arItemProperty['name']}}
                                        </option>
                                    @endforeach
                                    @php
                                        $i++;
                                    @endphp
                                </select>
                            @endif
                        </div>
                        <div class="col-md-1 d-flex align-items-center colListProperty">
                            <input type="checkbox" name="active_{{$arItem['id']}}"
                            @if($arItem['active'])
                                checked
                            @endif
                            >
                        </div>
                        <div class="col-md-3 colListProperty">
                            <input type="text" name="symbolCode_{{$arItem['id']}}" value="{{old('symbolCode_'.$arItem['id'],$arItem['user_symbol_code'])}}">
                        </div>
                        <div class="col-md-1 colListProperty">
                            <p>
                                {{$arItem['id']}}
                            </p>
                        </div>
                        <div class="col-md-1">
                            <input type="checkbox" name="propId_{{$arItem['id']}}">
                        </div>
                    </div>
                    @endforeach
                    <div class="wrapAdditionalPropertyJs">
                        <?php
                            $JsRow = Session::get('JsRow');
                            $HiddenMaxId = Session::get('HiddenMaxId');
                        ?>
                        @if($HiddenMaxId)
                            <input type="hidden" ref="maxIdJsProperty" value="{{$HiddenMaxId}}">
                        @endif
                        {!! $JsRow !!}
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <div class="btnAddRowAdditionalProperty" @click="addRow">
                                Добавить строку
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input
                                @click="displayPreloader"
                                class="btnSaveAdditionalProperty"
                                type="submit"
                                value="Сохранить"
                            >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
