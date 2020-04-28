<?php

namespace App\Library\InteractChain;

use App\Models\Category;

class Chain
{
    /**
     * @param null $id - ID подкатегории
     * @return array
     * Возвращает массив цепочки
     */
    public static function getArChain($id=null)
    {
        $idSuperCategory=null;
        $parent=$id;
        $arChain=[];

        if ($id!=null) {
            while ($idSuperCategory==null) {
                if(Category::find($parent)->parent_category!=null)
                {
                    $arChain[Category::find($parent)->id]=Category::find($parent)->name;

                    $parent=Category::find($parent)->parent_category->id;
                }else{
                    $arChain[Category::find($parent)->id]=Category::find($parent)->name;
                    $arChain['/']='Главные категории';

                    $idSuperCategory=Category::find($parent)->id;
                }
            }
        } else {
            $arChain['/']='Главные категории';
        }

        return array_reverse($arChain,true);
    }
}
