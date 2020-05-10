<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetAdditionalProperty extends Model
{
    public function listAdditionalProperty()
    {
        return $this->belongsTo(ListAdditionalProperty::class, 'property_id');
    }

    public function categoryProperty()
    {
        return $this->belongsTo(Category::class);
    }

    protected $fillable=[
        'property_id',
        'category_id',
        'active',
        'user_symbol_code',
        'value',
        'name',
        'defaultVal',
        'width',
        'height',
    ];

    public static function updateExistingProperties(
        $arIdExistingSetAdditional,
        $arNameExistingSetAdditional,
        $arListPropertyExistingSetAdditional,
        $arActiveExistingSetAdditional,
        $arSymbolCodeExistingSetAdditional,
        $idCategory,
        $arSettingAdditionalProp
    ){
        $i=0;
        foreach ($arIdExistingSetAdditional as $arId)
        {
            SetAdditionalProperty::find($arId)->update([
                'property_id'=>$arListPropertyExistingSetAdditional[$i],
                'category_id'=>$idCategory,
                'name'=>$arNameExistingSetAdditional[$i],
                'active'=>array_key_exists($arId,$arActiveExistingSetAdditional)? true:false,
                'user_symbol_code'=>$arSymbolCodeExistingSetAdditional[$i],
                'defaultVal'=>$arSettingAdditionalProp[$i]['defaultValue'],
                'width'=>array_key_exists('width',$arSettingAdditionalProp[$i])? $arSettingAdditionalProp[$i]['width']:null,
                'height'=>array_key_exists('height',$arSettingAdditionalProp[$i])? $arSettingAdditionalProp[$i]['height']:null,
            ]);
            $i++;
        }
    }

    public static function saveNewProperties(
        $idSuperCategory,
        $arNewProperties
    ){
        $i=0;
        foreach ($arNewProperties as $arItem)
        {
            $setProperties=new SetAdditionalProperty();
            $setProperties->property_id = $arItem['JSlistProperties'];
            $setProperties->category_id = $idSuperCategory;
            $setProperties->name = $arItem['JSpropertyName'];
            $setProperties->active = array_key_exists('JSactive', $arItem)? true:false;
            $setProperties->user_symbol_code  = $arItem['JSsymbolCode'];
            $setProperties->defaultVal  = array_key_exists('JSsettingAdditionalPropDefaultValInput',$arItem)? $arItem['JSsettingAdditionalPropDefaultValInput']:$arItem['JSsettingAdditionalPropDefaultValTextArea'];
            $setProperties->width  = array_key_exists('JSwidthTextArea',$arItem)? $arItem['JSwidthTextArea']:null;
            $setProperties->height  = array_key_exists('JSheightTextArea',$arItem)? $arItem['JSheightTextArea']:null;

            $setProperties->save();

            $i++;
        }
    }

    public static function deleteSetProperties($arIdProperties)
    {
        foreach ($arIdProperties as $arItem)
        {
            StorageValSetAdditionalProp::where('set_additional_prop_id',$arItem)->delete();
            SetAdditionalProperty::destroy($arItem);
        }
    }
}
