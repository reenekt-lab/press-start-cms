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

    protected $fillable=['property_id','category_id','active','user_symbol_code','value'];

    public static function updateExistingProperties(
        $arIdExistingSetAdditional,
        $arNameExistingSetAdditional,
        $arListPropertyExistingSetAdditional,
        $arActiveExistingSetAdditional,
        $arSymbolCodeExistingSetAdditional,
        $idCategory
    ){
        $i=0;
        foreach ($arIdExistingSetAdditional as $arId)
        {
            SetAdditionalProperty::find($arId)->update([
                'property_id'=>$arListPropertyExistingSetAdditional[$i],
                'category_id'=>$idCategory,
                'active'=>array_key_exists($arId,$arActiveExistingSetAdditional)? true:false,
                'user_symbol_code'=>$arSymbolCodeExistingSetAdditional[$i],
            ]);
            $i++;
        }
    }

    public static function saveNewProperties(
        $idSuperCategory,
        $arNewProperties,
        $arNewSymbolCode
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
