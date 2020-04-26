<?php

namespace App\Library\ActionList;

use App\Models\Category;
use App\Models\Content;
use App\Models\SetAdditionalProperty;
use App\Models\StorageValSetAdditionalProp;

class ActionContentPage
{
    /**
     * Логика удаления:
     * Есть категория, а у категории есь подкатегория, а у подкатегории есть своя полкатегория и.д.
     * Нужно пройтись в цикле и найти ту категорию, где parent_id==null
     * Получив массив категории и подкатегории, мы можем не только удалить категории и подкатегории, но и контент, хранящиеся в категории
     * Но полученный массив нужно проходить не сначало, а наоборот, с последнего индекса
     */

    public static function actionList($newRequest)
    {
        $category=[];
        $content=[];
        foreach ($newRequest as $key=>$value)
        {
            $pieces=explode('_',$key);

            //Если идентификатор "category"
            if($pieces[0]=='category')
                array_push($category,$pieces[1]);
            else if($pieces[0]=='content')
                array_push($content,$pieces[1]);
        }

        if($newRequest['option_action']=='Активировать')
        {
            //Если массив $content не путсой
            if (sizeof($content)!=0)
            {
                //Проходим по массиву "$content" и проставляем active=>true контенту, в зависимости от массива
                foreach ($content as $arItem)
                {
                    Content::where('id',$arItem)->update(['active'=>true]);
                }
            }

            //Еслм массив $category не пустой
            if(sizeof($category))
            {
                //Проходим по массиву "$category" и проставляем active=>true категориям, в зависимости от массива
                foreach ($category as $arItem)
                {
                    Category::where('id',$arItem)->update(['active'=>true]);
                }
            }
        } elseif($newRequest['option_action']=='Деактивировать')
        {
            //Если массив $content не путсой
            if(sizeof($content))
            {
                //Проходим по массиву "$content" и проставляем active=>false контенту, в зависимости от массива
                foreach ($content as $arItem)
                {
                    Content::where('id',$arItem)->update(['active'=>false]);
                }
            }

            //Еслм массив $category не пустой
            if(sizeof($category))
            {
                //Проходим по массиву "$category" и проставляем active=>false категориям, в зависимости от массива
                foreach ($category as $arItem)
                {
                    Category::where('id',$arItem)->update(['active'=>false]);
                }
            }
        } else
        {
            if(sizeof($category)>0)
            {
                ActionContentPage::getArraySubCategory($category);
            }

            if(sizeof($content))
            {
                foreach ($content as $arItem)
                {
                    $content=Content::find($arItem)->category;

                    //Удаляем строку в таблице "category_content"
                    foreach ($content as $arCategory)
                    {
                        $content_id=Content::find($arItem)->id;
                        $arCategory->content()->detach($content_id);
                    }

                    StorageValSetAdditionalProp::where('content_id',$arItem)->delete();

                    Content::destroy($arItem);
                }
            }
        }
    }

    /**
     * Получаю массив всех подкатегорий, в зависимости какую категорию выбрали
     */
    public static function getArraySubCategory($category)
    {
        //Юзер мог выбрать 2 и больше категории
        //И мы проходим по полученному массиву, где хранятся выбранные категории
        foreach ($category as $parentCategory)
        {
            //Этот массив будет хранить подкатегории и категории подкатегорий
            $arSubCategory=[];

            //Добавляю элемент в массив категорию
            array_push($arSubCategory,$parentCategory);

            //Получаем коллекцию родительской категории
            $var1=Category::find($parentCategory);

            //Получаем коллецкию подкатегорий, проходим по полученныи дочерним подкатегориям
            //чтобы узнать, есть ли у этих подкатегорий свои подкатегории
            foreach ($var1->sub_category as $arItem)
            {
                array_push($arSubCategory,$arItem->id);

                //Если у категории есть подкатегории
                if(count($arItem->sub_category)>0)
                {
                    $arSubCategory=ActionContentPage::getSubcategory($arSubCategory,$arItem);
                }
            }

            //Инверсирую индексы массива
            $arSubCategory=array_reverse($arSubCategory);

            ActionContentPage::deleteCategoryAndContent($arSubCategory);
        }
    }

    /**
     * @param $arSubCategory - массив в котором хранятся подкатегории
     * @param $arItemCategory - коллекция родительской категории
     * @return - возвращаещает массив, в котором хранятся подкатегория
     */

    public static function getSubcategory($arSubCategory,$arItemCategory)
    {
        foreach ($arItemCategory->sub_category as $arItem)
        {
            array_push($arSubCategory,$arItem->id);
            if(count($arItem->sub_category)>0)
            {
                $arSubCategory=ActionContentPage::getSubcategory($arSubCategory,$arItem);
            }
        }

        return $arSubCategory;
    }

    /**
     * удаляет категории и контент исходя, что хранится в массиве $arSubCategory
     * @param $arSubCategory - массив подкатегорий, в зависимости от выбранной категории
     */
    public static function deleteCategoryAndContent($arSubCategory)
    {
        //Хранит массив контента в категории
        $arContent=[];

        foreach ($arSubCategory as $arItem)
        {
            $category=Category::find($arItem);
            $arContent=ActionContentPage::getArContent($category);

            ActionContentPage::deleteContentCategoryTable($arContent,$arItem);

            SetAdditionalProperty::where('category_id',$arItem)->delete();

            //Удаляет категорию
            Category::destroy($arItem);
        }
    }

    public static function getArContent($category)
    {
        //Хранит массив id контента, которые находятся в выбранной категории
        $A=[];
        foreach ($category->content as $arContent)
        {
            array_push($A,$arContent->id);
        }

        return $A;
    }

    /**
     * Удаляет строку в таблице "category_user" и удаляет контент
     * @param $arContent - хранит массив контента, находящиеся в выбранной категории
     * @param $arItem - id категории на данной иттерации цикла
     */
    public static function deleteContentCategoryTable($arContent,$arItem)
    {
        foreach ($arContent as $contentId)
        {
            //Удаляем записи в связанной таблице "category_content"
            $category = Category::find($arItem);
            $content_id = Content::find($contentId)->id;
            $category->content()->detach($content_id);

            StorageValSetAdditionalProp::where('content_id',$content_id)->delete();

            //Удаляем контент
            Content::destroy($content_id);
        }
    }
}
