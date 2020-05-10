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
                <form method="post" action="{{route('add_property',$id)}}">
                    @csrf
                    @php
                        $i=0;
                    @endphp
                    <table class="tableAdditionalProp">
                        <tr>
                            <td class="tdTitleProp">
                                <div class="colTitleListProperty">
                                    <p>
                                        Название
                                    </p>
                                </div>
                            </td>
                            <td class="tdTypeProp">
                                <div class="colTitleListProperty">
                                    <p>
                                        Тип свойства
                                    </p>
                                </div>
                            </td>
                            <td class="tdActiveProp">
                                <div class="colTitleListProperty colActive">
                                    <p>
                                        Активно
                                    </p>
                                </div>
                            </td>
                            <td class="tdSympolCodeProp">
                                <div class="colTitleListProperty">
                                    <p>
                                        Символьный код
                                    </p>
                                </div>
                            </td>
                            <td class="tdToChangeProp">
                                <div class="colTitleListProperty">
                                    <p>
                                        Изм...
                                    </p>
                                </div>
                            </td>
                            <td class="tdIdProp">
                                <div class="colTitleListProperty">
                                    <p>
                                        ID
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="colTitleListProperty">
                                    <p>
                                        Удалить
                                    </p>
                                </div>
                            </td>
                        </tr>

                        @foreach($arSetAdditionalProperty as $arItem)
                        <tr class="trAdditionalProp">
                            <td>
                                <input type="text" name="propertyName_{{$arItem['id']}}" value="{{old('propertyName_'.$arItem['id'],$arItem['name'])}}">
                            </td>
                            <td>
                                @if(array_key_exists('listProperties_'.$arItem['id'],old()))
                                    <select class="listProperties_{{$arItem['id']}}" name="listProperties_{{$arItem['id']}}">
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
                                    <select class="listProperties_{{$arItem['id']}}" name="listProperties_{{$arItem['id']}}">
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
                            </td>
                            <td class="tdActiveProp">
                                <input type="checkbox" name="active_{{$arItem['id']}}"
                                   @if($arItem['active'])
                                   checked
                                   @endif>
                            </td>
                            <td>
                                <input
                                    type="text"
                                    name="symbolCode_{{$arItem['id']}}"
                                    value="{{old('symbolCode_'.$arItem['id'],$arItem['user_symbol_code'])}}"
                                >
                            </td>
                            <td>
                                <div
                                    @click="displayModalWindow('{{$arItem->id}}')"
                                    class="btnDisplayNewProp"
                                >
                                    ...
                                </div>
                            </td>
                            <td>
                                <div class="additionalPropId">
                                    {{$arItem['id']}}
                                </div>
                            </td>
                            <td class="tdBtnToDel">
                                <input type="checkbox" name="propId_{{$arItem['id']}}">
                            </td>
                        </tr>

                        @include('system.admin_page.setting.additionalProperty.include.formNewSettingPropInput')
                        @include('system.admin_page.setting.additionalProperty.include.formNewSettingPropTextArea')

                        @endforeach

                        <!--Если запрос не прошёл валидацию, то возвращает JS строки-->
                        @php
                            $JsRow = Session::get('JsRow');
                            $HiddenMaxId = Session::get('HiddenMaxId');
                        @endphp
                        {!! $JsRow !!}


                        <!--если валидация не прошла, то созданные модальные окна отображаются-->
                        @php
                            $JsModalInput=Session::get('modalWindowInput');
                            $JsModalTextArea=Session::get('modalWindowTextArea');
                        @endphp
                        {!! $JsModalInput !!}
                        {!! $JsModalTextArea !!}

                        <!--Отображение нововой JS строки по нажатию кнопки-->
                        @include('system.admin_page.setting.additionalProperty.include.addNewRow.newRowProp')

                        <!--Max ID необходимо, чтобы можно было добавлять новые строки при провале валиадции-->
                        @if($HiddenMaxId)
                            <input type="hidden" ref="maxIdJsProperty" value="{{$HiddenMaxId}}">
                        @endif

                    </table>

                    <!--JS модальные формы-->
                    <div v-for="JsItem in countNewRow">
                        @include('system.admin_page.setting.additionalProperty.include.addNewRow.formNewSettingPropInput')
                        @include('system.admin_page.setting.additionalProperty.include.addNewRow.formNewSettingPropTextArea')
                    </div>

                    <div class="wrapBtnAddNewRowAndSave">
                        <div class="wrapAddNewRow">
                            <div
                                class="btnAddRowAdditionalProperty"
                                @click="addRow"
                            >
                                Добавить строку
                            </div>
                        </div>
                        <div>
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
