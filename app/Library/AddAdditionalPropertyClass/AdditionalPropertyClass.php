<?php

namespace App\Library\AddAdditionalPropertyClass;

use App\Http\Controllers\Controller;
use App\Models\ListAdditionalProperty;
use App\Models\SetAdditionalProperty;
use phpDocumentor\Reflection\Types\Self_;

class AdditionalPropertyClass
{
    /**
     * @param $newRequest
     * @param $id
     * Изменяет существующие свойства
     */
    public static function updateExistingProperties($newRequest, $id)
    {
        $arIdExistingSetAdditional = self::getArrayIdProperty($id);
        $arNameExistingSetAdditional = self::convertToArrayExistingName($newRequest);
        $arListPropertyExistingSetAdditional = self::convertToArrayExistingListProperty($newRequest);
        $arActiveExistingSetAdditional = self::convertToArrayExistingActive($newRequest);
        $arSymbolCodeExistingSetAdditional = self::convertToArrayExistingSymbolCode($newRequest);
        $arSettingAdditionalProp = self::getArraySettingAdditionalProp($newRequest);

        SetAdditionalProperty::updateExistingProperties(
            $arIdExistingSetAdditional,
            $arNameExistingSetAdditional,
            $arListPropertyExistingSetAdditional,
            $arActiveExistingSetAdditional,
            $arSymbolCodeExistingSetAdditional,
            $id,
            $arSettingAdditionalProp
        );
    }

    /**
     * @param $newRequest
     * @param $id
     * @return bool
     * Валидация на пустоту и на null.
     * Пример.
     * Отобразился список свойств, в зависимости от категорий и юзер
     * существующей свойству убрал название, тогда отображается ему ошибка об этом
     */
    public static function validationExistingName($newRequest, $id)
    {
        $arPropertyName = [];
        $errorNullVal = false;
        $arAdditionalPropId = AdditionalPropertyClass::getArrayIdProperty($id);

        foreach ($newRequest as $key => $value) {
            $pieces = explode('_', $key);

            if ($pieces[0] == 'propertyName')
                $arPropertyName[$pieces[1]] = $value;
        }

        foreach ($arAdditionalPropId as $arItem) {
            $arPropertyName[$arItem] == null ? $errorNullVal = true : '';
        }

        return $errorNullVal;
    }

    public static function getArrayIdProperty($id)
    {
        $arSetAdditionalProperty = SetAdditionalProperty::where('category_id', $id)->get();
        $arIdSetAdditional = [];

        foreach ($arSetAdditionalProperty as $arItem) {
            array_push($arIdSetAdditional, $arItem->id);
        }

        return $arIdSetAdditional;
    }

    /**
     * @param $newRequest - это $request->except('_token')
     * @param $id - id выбранной категории
     * @return bool
     * Проверяет на уникальность символьного кода свойства:
     */
    public static function checkExistingUniqueSymbolCode($newRequest, $id)
    {
        $arSymbolCode = AdditionalPropertyClass::convertToArrayExistingSymbolCode($newRequest);
        $arUniqueSymbolCode = AdditionalPropertyClass::getArraySymbolCode();

        //Здесь логика такая
        //Получаем массив всех свойст из выбранной "Главной категории"
        //И проверяем, дублируется ли символьный код
        foreach ($arUniqueSymbolCode as $arItem) {
            if ($arItem) {
                $countSymbolCode = array_filter($arSymbolCode, function ($symbolCode) use ($arItem) {
                    return $symbolCode == $arItem;
                });

                if (count($countSymbolCode) > 1) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param $id - id выбранной категории
     * @return array
     * Создается запрос на получения всех свойств выбранной "Главной категории"
     */
    public static function getArraySymbolCode()
    {
        $arSymbolCode = [];

        $arExistingSymbolCode = SetAdditionalProperty::all(['user_symbol_code']);

        foreach ($arExistingSymbolCode as $arItem) {
            array_push($arSymbolCode, $arItem->user_symbol_code);
        }

        return $arSymbolCode;
    }

    /**
     * @param $newRequest
     * @return array
     * Преобразует в массив уже существующие названия символьного кода из request
     */
    public static function convertToArrayExistingSymbolCode($newRequest)
    {
        $arSymbolCode = [];
        $arUniqueSymbolCode = [];

        foreach ($newRequest as $key => $value) {
            $pieces = explode('_', $key);

            if ($pieces[0] == 'symbolCode') {
                $result = preg_replace("/\s+/", "", $value);
                array_push($arSymbolCode, $result);
            }
        }

        return $arSymbolCode;
    }

    /**
     * @param $newRequest
     * @return array
     * Преобразует в массив уже существующие названия свойств из request
     */
    public static function convertToArrayExistingName($newRequest)
    {
        $arName = [];

        foreach ($newRequest as $key => $value) {
            $pieces = explode('_', $key);

            if ($pieces[0] == 'propertyName')
                array_push($arName, $value);
        }

        return $arName;
    }

    /**
     * @param $newRequest
     * @return array
     * Преобразует в массив уже существующие  типов свойств из request
     */
    public static function convertToArrayExistingListProperty($newRequest)
    {
        $arListProperty = [];

        foreach ($newRequest as $key => $value) {
            $pieces = explode('_', $key);

            if ($pieces[0] == 'listProperties')
                array_push($arListProperty, $value);
        }

        return $arListProperty;
    }

    /**
     * @param $newRequest
     * @return array
     * Преобразует в массив уже существующие  типов свойств из request
     */
    public static function convertToArrayExistingActive($newRequest)
    {
        $arActive = [];

        foreach ($newRequest as $key => $value) {
            $pieces = explode('_', $key);

            if ($pieces[0] == 'active')
                $arActive[$pieces[1]] = $value;
        }

        return $arActive;
    }

    public static function checkRussiaWordsInExistingProperty($newRequest, $id)
    {
        $arSymbolCode = AdditionalPropertyClass::convertToArrayExistingSymbolCode($newRequest);

        foreach ($arSymbolCode as $arItem) {
            if (preg_match('@[А-я]@u', $arItem)) {
                return true;
            }
        }

        return false;
    }

    public static function validationNewUniqueSymbolCode($newRequest, $id)
    {
        $arIdMewProperty = AdditionalPropertyClass::getArrayNewIdProperty($newRequest);
        $arNewSymbolCode = AdditionalPropertyClass::convertToArrayNewSymbolCode($newRequest, $arIdMewProperty);
        $errorUniqueSymbolCode = AdditionalPropertyClass::checkUniqueInsideArrayNewSymbolCode($arNewSymbolCode);

        if (!$errorUniqueSymbolCode) {
            foreach ($arNewSymbolCode as $arItem) {
                if ($arItem != null) {
                    $count = SetAdditionalProperty::where('user_symbol_code', $arNewSymbolCode)->count();
                    if ($count > 0) {
                        $errorUniqueSymbolCode = true;
                        break;
                    }
                }
            }

            return $errorUniqueSymbolCode;
        } else {
            return $errorUniqueSymbolCode;
        }

    }

    /**
     * @param $newRequest
     * @return array
     * Возвращает список ID новых свойств
     */
    public static function getArrayNewIdProperty($newRequest)
    {
        $arIdMewProperty = [];

        foreach ($newRequest as $key => $value) {
            $pieces = explode('_', $key);
            if ($pieces[0] == 'JSpropertyName' && $value != null)
                array_push($arIdMewProperty, $pieces[1]);
        }

        return $arIdMewProperty;
    }

    /**
     * @param $newRequest - это $request
     * @param $arIdMewProperty - ID всех добавленных свойств
     * @return array
     * Возвращает массив новых символьных кодов, в зависимости, где было заполнено название свойства
     */
    public static function convertToArrayNewSymbolCode($newRequest, $arIdMewProperty)
    {
        $arNewSymbolCode = [];

        foreach ($newRequest as $key => $value) {
            $pieces = explode('_', $key);
            if ($pieces[0] == 'JSsymbolCode') {
                //Выбираем лишь те символьные коды, чъи ID равно ID заполненного названия свойства
                foreach ($arIdMewProperty as $arItem) {
                    if ($arItem == $pieces[1]) {
                        $result = preg_replace("/\s+/", "", $value);
                        array_push($arNewSymbolCode, $result);
                        break;
                    }
                }
            }
        }

        return $arNewSymbolCode;
    }

    /**
     * @param $arNewSymbolCode - символьный код новых свойств
     * @return bool
     * Проверка на уникальность символьного нового символьного кода внутри массива
     */
    public static function checkUniqueInsideArrayNewSymbolCode($arNewSymbolCode)
    {
        $errorUniqueSymbolCode = false;

        foreach ($arNewSymbolCode as $key => $value) {
            if ($value != '') {
                foreach ($arNewSymbolCode as $innerKey => $innerValue) {
                    if ($key != $innerKey) {
                        if ($value == $innerValue) {
                            $errorUniqueSymbolCode = true;
                            break;
                        }
                    }
                }
                if ($errorUniqueSymbolCode)
                    break;
            }
        }

        return $errorUniqueSymbolCode;
    }

    /**
     * @param $newRequest
     * @param $id
     * @return bool
     * Проверка на русские буквы в новых введенных свойств
     */
    public static function checkRussiaWordsInNewPropertySymbolCode($newRequest, $id)
    {
        $arIdMewProperty = AdditionalPropertyClass::getArrayNewIdProperty($newRequest);
        $arNewSymbolCode = AdditionalPropertyClass::convertToArrayNewSymbolCode($newRequest, $arIdMewProperty);

        foreach ($arNewSymbolCode as $arItem) {
            if (preg_match('@[А-я]@u', $arItem)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $newRequest
     * @return mixed
     * Возвращает maxID и html верстку
     */
    public static function htmlRow($newRequest)
    {
        $html = '';
        $count = 1;

        $arNewProperties = AdditionalPropertyClass::getArrayNewProperties($newRequest);
        $properties = AdditionalPropertyClass::getAllProperties();

        foreach ($arNewProperties as $arItem) {
            $html .= '<tr class="trAdditionalProp">';

            $html .= '<td>
                        <input type="text" name="JSpropertyName_' . $count . '" value="' . $arItem['JSpropertyName'] . '">
                    </td>
                    <td>' . self::htmlTagSelect($properties, $count, $newRequest, $arItem) . '</td>
                    <td class="tdActiveProp">
                        <input type="checkbox" name="JSactive_' . self::checkActiveCheckbox($arItem) . '">
                    </td>
                    <td>
                        <input type="text" name="JSsymbolCode_' . $count . '" value="' . $arItem['JSsymbolCode'] . '">
                    </td>
                    <td>
                        <div
                            @click="JSopenModalWindow('.$count.')"
                            class="btnDisplayNewProp"
                        >
                            ...
                        </div>
                    </td>
                    <td></td>';

            $html .= '</tr>';

            $count++;
        }

        $finalArray['html'] = $html;
        $finalArray['maxId'] = $count;

        return $finalArray;
    }

    /**
     * @param $newRequest - это $request
     * @return array
     * Выдает массив всех только что написанных свойств
     */
    public static function getArrayNewProperties($newRequest)
    {
        $arNewProperties = [];
        $A=[];
        $idProp=0;

        foreach ($newRequest as $key => $value) {
            $pieces = explode('_', $key);

            if ($pieces[0]=='JSpropertyName' && $value!=null) {

                $A[$pieces[0]]=$value;
                $A['JSlistProperties']=$newRequest['JSlistProperties_'.$pieces[1]];
                $A['JSactive']=array_key_exists('JSactive_'.$pieces[1],$newRequest)? $newRequest['JSactive_'.$pieces[1]]:false;
                $A['JSsymbolCode']=$newRequest['JSsymbolCode_'.$pieces[1]];

                $idProp=$newRequest['JSlistProperties_'.$pieces[1]];

                if ($idProp==1) {
                    $A['JSsettingAdditionalPropDefaultValInput']=$newRequest['JSsettingAdditionalPropDefaultValInput_'.$pieces[1]];
                }
                if ($idProp==2) {
                    $A['JSsettingAdditionalPropDefaultValTextArea']=$newRequest['JSsettingAdditionalPropDefaultValTextArea_'.$pieces[1]];
                    $A['JSwidthTextArea']=$newRequest['JSwidthTextArea_'.$pieces[1]];
                    $A['JSheightTextArea']=$newRequest['JSheightTextArea_'.$pieces[1]];
                }
            }

            if (count($A)>0) {
                array_push($arNewProperties, $A);
            }
            $A = [];
        }

        return $arNewProperties;
    }

    public static function getAllProperties()
    {
        $properties = ListAdditionalProperty::all(['id', 'name']);

        return $properties;
    }

    /**
     * @param $properties - хранит коллекцию всех свойств
     * @param $count - хранит данные счетчика
     * @param $newRequest - это $request
     * @return string
     */

    public static function htmlTagSelect($properties, $count, $newRequest, $arItemOuter)
    {
        $htmlSelect = '<select class="JSlistProperties_'.$count.'" name="JSlistProperties_' . $count . '">';

        foreach ($properties as $arItem) {
            $htmlSelect .= '<option value="' . $arItem['id'] . '" ' . self::getSelectedTypeProperty($newRequest, $arItem, $count) . '>' . $arItem['name'] . '</option>';
        }

        $htmlSelect .= '</select>';

        return $htmlSelect;
    }

    /**
     * @param $newRequest - это $request
     * @param $arItem - иттерация цикла коллекции, где хранятся все свойства
     * @param $count - счётчик
     * @return string
     */
    public static function getSelectedTypeProperty($newRequest, $arItem, $count)
    {
        if ($newRequest['JSlistProperties_' . $count] == $arItem->id) {
            return 'selected';
        } else {
            return '';
        }
    }

    public static function checkActiveCheckbox($arItem)
    {
        if (array_key_exists('JSactive', $arItem)) {
            return 'checked';
        } else
            return '';
    }

    public static function saveNewAdditionalProperty($newRequest, $id)
    {
        $arNewProperty = self::getArrayNewProperties($newRequest);

        if (sizeof($arNewProperty) > 0) {
            SetAdditionalProperty::saveNewProperties($id, $arNewProperty);
        }
    }

    public static function deleteProperties($newRequest, $id)
    {
        $arIdProperties = self::getArrayDeletePropId($newRequest);

        SetAdditionalProperty::deleteSetProperties($arIdProperties);
    }

    /**
     * @param $newRequest - это $request
     * @return array
     * Выдает массив ID выбранных свойств
     */
    public static function getArrayDeletePropId($newRequest)
    {
        $arIdProperties = [];

        foreach ($newRequest as $key => $value) {
            $pieces = explode('_', $key);

            if ($pieces[0] == 'propId')
                array_push($arIdProperties, $pieces[1]);
        }

        return $arIdProperties;
    }

    /**
     * @param $newRequest
     * @return array
     * Возвращает массив значений из модальных окон
     */
    public static function getArraySettingAdditionalProp($newRequest)
    {
        $arSettingAdditionalProp=[];

        foreach ($newRequest as $key=>$value) {
            $A=[];
            $pieces=explode('_',$key);

            //Получаем $value из индекса "listProperties_"
            if ($pieces[0]=='listProperties') {
                foreach ($newRequest as $innerKey=>$innerValue) {
                    // Если input
                    if($value==1) {
                        $innerPieces=explode('_',$innerKey);

                        //Т.к. мы находимся сейчас в Input
                        //Необходимо взять значения для Input
                        //$pieces[1]==$innerPieces[1] -> чтобы данные не перезаписывались
                        if ($innerPieces[0]=='settingAdditionalPropDefaultValInput' && $pieces[1]==$innerPieces[1]) {
                            $A['defaultValue']=$innerValue;
                        }
                    //если textArea
                    } elseif ($value==2) {
                        $innerPieces=explode('_',$innerKey);

                        //$pieces[1]==$innerPieces[1] -> чтобы данные не перезаписывались
                        if ($innerPieces[0]=='settingAdditionalPropDefaultValTextArea' && $pieces[1]==$innerPieces[1]) {
                            $A['defaultValue']=$innerValue;
                        }

                        //$pieces[1]==$innerPieces[1] -> чтобы данные не перезаписывались
                        if($innerPieces[0]=='widthTextArea' && $pieces[1]==$innerPieces[1]) {
                            $A['width']=$innerValue;
                        }

                        //$pieces[1]==$innerPieces[1] -> чтобы данные не перезаписывались
                        if($innerPieces[0]=='heightTextArea' && $pieces[1]==$innerPieces[1]) {
                            $A['height']=$innerValue;
                        }
                    }
                }
            }

            if (sizeof($A)>0) {
                array_push($arSettingAdditionalProp,$A);
            }
        }

        return $arSettingAdditionalProp;
    }

    public static function getHtmlModalWindowInput($newRequest)
    {
        $arSettingVal=self::getArrayNewProperties($newRequest);
        $count=1;
        $html='';

        foreach ($arSettingVal as $arItem) {
            if ($arItem['JSlistProperties']==1) {

                $html.='<div
                        class="bgFormSettingAddProp JSbgFormSettingInputAddProp_'.$count.'"
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
                                        name="JSsettingAdditionalPropDefaultValInput_'.$count.'"
                                        value="'.$arItem['JSsettingAdditionalPropDefaultValInput'].'"
                                    >
                                </div>
                            </div>
                            <div class="wrapBlockBtnSaveSetting">
                                <div class="wrapLeftBlockBtnSettingAddProp">
                                    <div
                                        class="btnSaveSetting"
                                        @click="JScloseModalWindowProp('.$count.')"
                                    >
                                        Закрыть
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                $count++;

                continue;
            } else {

                $html.='<div
                        class="bgFormSettingAddProp JSbgFormSettingInputAddProp_'.$count.'"
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
                                        name="JSsettingAdditionalPropDefaultValInput_'.$count.'"
                                    >
                                </div>
                            </div>
                            <div class="wrapBlockBtnSaveSetting">
                                <div class="wrapLeftBlockBtnSettingAddProp">
                                    <div
                                        class="btnSaveSetting"
                                        @click="JScloseModalWindowProp('.$count.')"
                                    >
                                        Закрыть
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                $count++;

                continue;
            }
        }

        return $html;
    }

    public static function getHtmlModalWindowTextArea($newRequest)
    {
        $arSettingVal=self::getArrayNewProperties($newRequest);
        $count=1;
        $html='';


        foreach ($arSettingVal as $arItem) {
            if ($arItem['JSlistProperties']==2) {

                $html.='<div
                            class="bgFormSettingAddProp JSbgFormSettingTextAreaAddProp_'.$count.'"
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
                                            name="JSsettingAdditionalPropDefaultValTextArea_'.$count.'"
                                            value="'.$arItem['JSsettingAdditionalPropDefaultValTextArea'].'"
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
                                            name="JSwidthTextArea_'.$count.'"
                                            value="'.$arItem['JSwidthTextArea'].'"
                                        >
                                        <p>
                                            X
                                        </p>
                                        <input
                                            type="text"
                                            name="JSheightTextArea_'.$count.'"
                                            value="'.$arItem['JSheightTextArea'].'"
                                        >
                                    </div>
                                </div>
                                <div class="wrapBlockBtnSaveSetting">
                                    <div class="wrapLeftBlockBtnSettingAddProp">
                                        <div
                                            @click="JScloseModalWindowProp('.$count.')"
                                            class="btnSaveSetting"
                                        >
                                            Закрыть
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';

                $count++;
                continue;
            } else {
                $html.='<div
                            class="bgFormSettingAddProp JSbgFormSettingTextAreaAddProp_'.$count.'"
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
                                            name="JSsettingAdditionalPropDefaultValTextArea_'.$count.'"
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
                                            name="JSwidthTextArea_'.$count.'"
                                        >
                                        <p>
                                            X
                                        </p>
                                        <input
                                            type="text"
                                            name="JSheightTextArea_'.$count.'"
                                        >
                                    </div>
                                </div>
                                <div class="wrapBlockBtnSaveSetting">
                                    <div class="wrapLeftBlockBtnSettingAddProp">
                                        <div
                                            @click="JScloseModalWindowProp('.$count.')"
                                            class="btnSaveSetting"
                                        >
                                            Закрыть
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';

                $count++;
                continue;
            }
        }

        return $html;
    }
}
