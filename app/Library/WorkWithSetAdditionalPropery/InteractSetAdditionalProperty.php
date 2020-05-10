<?php

namespace App\Library\WorkWithSetAdditionalPropery;

use App\Models\Category;
use App\Models\Content;
use App\Models\SetAdditionalProperty;
use App\Models\StorageValSetAdditionalProp;

class InteractSetAdditionalProperty
{
    /**
     * @param $id
     * @return |null
     * Возвращает список дополнительных свойст, если они есть
     */
    public static function getSetAdditionalProperty($id)
    {
        $idSuperCategory=self::getIdSelectedSuperCategory($id);

        $arSetAdditionalProperties=SetAdditionalProperty::where('category_id',$idSuperCategory)
                                                        ->where('active',true)
                                                        ->get();

        if(sizeof($arSetAdditionalProperties)>0)
            return $arSetAdditionalProperties;
        else
            return null;
    }

    /**
     * @param $id
     * @return mixed
     * Получение ID "супер категории", в которой создается контент
     */
    public static function getIdSelectedSuperCategory($id)
    {
        $idSuperCategory=null;
        $parent=$id;

        while ($idSuperCategory==null)
        {
            if(Category::find($parent)->parent_category!=null)
            {
                $parent=Category::find($parent)->parent_category->id;
            }else{
                $idSuperCategory=Category::find($parent)->id;
            }
        }

        return $idSuperCategory;
    }

    /**
     * @param $newRequest
     * Сохраняет введенное значение в дополнительные свойства
     */
    public static function saveValueAdditionalProperties($newRequest,$id, $idContent)
    {
        $isProperties=self::checkExistingProperties($newRequest);

        if ($isProperties) {
            StorageValSetAdditionalProp::saveValAdditionalProp(
                self::getArrayProperties($newRequest),
                self::getIdSelectedSuperCategory($id),
                $idContent
            );
        }
    }

    /**
     * @param $newRequest
     * @return bool
     * Проверяет наличие полей дополнительных свойств
     */
    public static function checkExistingProperties($newRequest)
    {
        foreach ($newRequest as $key=>$value)
        {
            $pieces=explode('_',$key);
            if($pieces[0]=='additionalProperty')
            {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $newRequest
     * @return array
     * Возвращает массив дополнительных свойтсв
     */
    public static function getArrayProperties($newRequest)
    {
        $arProperties=[];

        foreach ($newRequest as $key=>$value) {
            $pieces=explode('_',$key);

            if($pieces[0]=='additionalProperty') {
                $arProperties[$pieces[1]]=$value;
            }
            if ($pieces[0]=='additionalPropertyTextArea') {
                $arProperties[$pieces[1]]=$value;
            }
        }

        return $arProperties;
    }

    public static function updateValProp($newRequest, $idContent, $idCategory)
    {
        $isProperties=self::checkExistingProperties($newRequest);

        if ($isProperties) {
            StorageValSetAdditionalProp::updateValProp(self::getArrayProperties($newRequest),$idContent, self::getIdSelectedSuperCategory($idCategory));
        }
    }
}
