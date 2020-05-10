@php
    $countJsRow=0;
@endphp
<tr v-for="JsItem in countNewRow">
    <td>
        <input
            type="text"
            :name="'JSpropertyName_'+JsItem"
        >
    </td>
    <td v-html="htmlSelect(JsItem)"></td>
    <td class="tdActiveProp">
        <input
            type="checkbox"
            :name="'JSactive_'+JsItem"
            checked
        >
    </td>
    <td>
        <input
            type="text"
            :name="'JSsymbolCode_'+JsItem"
        >
    </td>
    <td>
        <div
            @click="JSopenModalWindow(JsItem)"
            class="btnDisplayNewProp"
        >
            ...
        </div>
    </td>
    <td></td>
</tr>
