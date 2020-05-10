<div
    class="bgFormSettingAddProp modalWindowInput_{{$arItem->id}}"
    ref="modalWindowInput_{{$arItem->id}}"
    style="display: none"
>
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
                    name="settingAdditionalPropDefaultValInput_{{$arItem->id}}"
                    value="{{old('settingAdditionalPropDefaultVal_'.$arItem->id,$arItem->defaultVal)}}"
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
