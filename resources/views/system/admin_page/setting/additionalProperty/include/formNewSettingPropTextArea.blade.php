<div class="bgFormSettingAddProp modalWindowTextArea_{{$arItem->id}}" ref="modalWindowTextArea{{$arItem->id}}" style="display: none">
    <div class="justWrap">
        <div class="wrapFormSettingAddProp">
            <div class="wrapAdminPageAddPropSettingLeft">
                <p>
                    Значение по умолчанию
                </p>
            </div>
            <div class="wrapAdminPageAddPropSettingRight">
                <input
                    type="text"
                    name="settingAdditionalPropDefaultValTextArea_{{$arItem->id}}"
                    value="{{old('settingAdditionalPropDefaultVal_'.$arItem->id,$arItem->defaultVal)}}"
                >
            </div>
        </div>
        <div class="wrapFormSettingAddProp">
            <div class="wrapAdminPageAddPropSettingLeft">
                <p>
                    Размер поля
                </p>
            </div>
            <div class="wrapAdminPageAddPropSettingRight sizeTextArea">
                <input
                    type="text"
                    name="widthTextArea_{{$arItem->id}}"
                    value="{{old('widthTextArea_'.$arItem->id,$arItem->width)}}"
                >
                <p>
                    Х
                </p>
                <input
                    type="text"
                    name="heightTextArea_{{$arItem->id}}"
                    value="{{old('heightTextArea_'.$arItem->id,$arItem->height)}}"
                >
            </div>
        </div>
        <div class="wrapBlockBtnSaveSetting">
            <div class="wrapLeftBlockBtnSettingAddProp">
                <div
                    @click="closeModalWindowProp({{$arItem->id}})"
                    class="btnSaveSetting"
                >
                    Закрыть
                </div>
            </div>
        </div>
    </div>
</div>
