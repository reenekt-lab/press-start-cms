<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageValSetAdditionalProp extends Model
{
    public function contentProp()
    {
        return $this->belongsTo(Content::class,'content_id');
    }

    public function setAdditionalProp()
    {
        return $this->belongsTo(SetAdditionalProperty::class,'set_additional_prop_id');
    }

    public static function saveValAdditionalProp(
        $arProperties,
        $idSuperCategory,
        $maxIdContent
    ){
        foreach ($arProperties as $key=>$value) {
            $k=new StorageValSetAdditionalProp();
            $k->super_category_id=$idSuperCategory;
            $k->content_id=$maxIdContent;
            $k->set_additional_prop_id=$key;
            $k->value=$value;

            $k->save();
        }
    }

    public static function updateValProp(
        $arProperties,
        $idContent,
        $idCategory
    ){
        $countRow=0;
        foreach ($arProperties as $key=>$value) {
            $countRow=StorageValSetAdditionalProp::where('content_id',$idContent)
            ->where('set_additional_prop_id',$key)->count();

            if($countRow>0) {
                StorageValSetAdditionalProp::where('content_id',$idContent)
                    ->where('set_additional_prop_id',$key)
                    ->update([
                        'value'=>$value
                    ]);
            } else {
                $valueProp=new StorageValSetAdditionalProp;
                $valueProp->super_category_id = $idCategory;
                $valueProp->content_id  = $idContent;
                $valueProp->set_additional_prop_id = $key;
                $valueProp->value = $value;

                $valueProp->save();
            }
        }
    }
}
