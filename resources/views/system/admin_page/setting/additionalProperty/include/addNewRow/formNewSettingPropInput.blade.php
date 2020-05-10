<div
    :class="'bgFormSettingAddProp JSbgFormSettingInputAddProp_'+JsItem"
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
                    :name="'JSsettingAdditionalPropDefaultValInput_'+JsItem"
                >
            </div>
        </div>
        <div class="wrapBlockBtnSaveSetting">
            <div class="wrapLeftBlockBtnSettingAddProp">
                <div
                    @click="JScloseModalWindowProp(JsItem)"
                    class="btnSaveSetting"
                >
                    Закрыть
                </div>
            </div>
        </div>
    </div>
</div>
