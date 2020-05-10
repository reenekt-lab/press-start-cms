<div
    :class="'bgFormSettingAddProp JSbgFormSettingTextAreaAddProp_'+JsItem"
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
                    :name="'JSsettingAdditionalPropDefaultValTextArea_'+JsItem"
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
                    :name="'JSwidthTextArea_'+JsItem"
                >
                <p>
                    Х
                </p>
                <input
                    type="text"
                    :name="'JSheightTextArea_'+JsItem"
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
