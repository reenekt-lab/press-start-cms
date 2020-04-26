<?php

namespace App\Http\Controllers\System\Admin;

use App\Http\Controllers\Controller;
use App\Library\AddAdditionalPropertyClass\AdditionalPropertyClass;
use App\Models\Category;
use App\Models\listAdditionalProperty;
use App\Models\SetAdditionalProperty;
use Illuminate\Http\Request;

class AdminSetting extends Controller
{
    public function displayListMainCategoriesSetting()
    {
        $arCategory=Category::where('super_category',true)->orderBy('name','asc')->get();

        return view('system.admin_page.setting.additionalProperty.list_super_category',compact('arCategory'));
    }

    public function displayFormAddProperty($id)
    {
        $arAdditionalProperty=ListAdditionalProperty::all(['id','name','type']);

        $arSetAdditionalProperty=SetAdditionalProperty::where('category_id',$id)->get();

        $maxId=SetAdditionalProperty::max('id');

        return view('system.admin_page.setting.additionalProperty.form_add_property',compact(
            'id',
            'arAdditionalProperty',
            'arSetAdditionalProperty',
            'maxId'
        ));
    }

    public function addProperty(Request $request,$id)
    {
        $msgErrorNullVal='';
        $msgErrorUniqueSymbolCode='';
        $msgErrorRussiaWords='';

        //Валидация существующих свойств
        $errorNulVal=AdditionalPropertyClass::validationExistingName($request->except('_token'),$id);
        $errorUniqueSymbolCode=AdditionalPropertyClass::checkExistingUniqueSymbolCode($request->except('_token'),$id);
        $errorRussiaWordsSymbolCode=AdditionalPropertyClass::checkRussiaWordsInExistingProperty($request->except('_token'),$id);

        //Валидация новых свойств
        $errorNewUniqueSymbolCode=AdditionalPropertyClass::validationNewUniqueSymbolCode($request->except('_token'),$id);
        $errorRussiaWordsNewSymbolCode=AdditionalPropertyClass::checkRussiaWordsInNewPropertySymbolCode($request->except('_token'),$id);

        if($errorNulVal || $errorUniqueSymbolCode || $errorRussiaWordsSymbolCode || $errorNewUniqueSymbolCode || $errorRussiaWordsNewSymbolCode)
        {
            $newAdditionalProperty=AdditionalPropertyClass::htmlRow($request->except('_token'));

            if($errorNulVal)
                $msgErrorNullVal='У свойства должно быть название';

            if($errorUniqueSymbolCode || $errorNewUniqueSymbolCode)
                $msgErrorUniqueSymbolCode='Символьный код должен быть уникальным';

            if($errorRussiaWordsSymbolCode || $errorRussiaWordsNewSymbolCode)
                $msgErrorRussiaWords='Символьный код должен состоять из английских букв';


            return redirect()->route('display_form_add_property',$id)->withErrors([
                'nameProp'=>$msgErrorNullVal,
                'symbolCodeUnique'=>$msgErrorUniqueSymbolCode,
                'russiaWord'=>$msgErrorRussiaWords,
            ])->withInput(
                $request->all()
            )->with([
                'JsRow'=>$newAdditionalProperty['html'],
                'HiddenMaxId'=>$newAdditionalProperty['maxId'],
                'displayAnotherSelect'=>true
            ]);
        }else
        {
            AdditionalPropertyClass::updateExistingProperties($request->except('_token'),$id);
            AdditionalPropertyClass::saveNewAdditionalProperty($request->except('_token'),$id);
            AdditionalPropertyClass::deleteProperties($request->except('_token'),$id);

            return redirect()->route('setting_list_main_category');
        }
    }
}
