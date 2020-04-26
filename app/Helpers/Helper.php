<?php

namespace App\Helpers;

use App\Models\All_themes;
use App\Models\Category;
use App\Models\Content;

class Helper
{
    /**
     * Данная функция helper подлкючает системные скрипты и стили,
     * необходимые для функционирования cms
     * (юзеру необходимо просто прописать данную helper функцию и необходимые скрипты и стили подключатся)
     *
     * В данную сборку входит:
     * 1) Bootstrap v4
     * 2) Системные стили, необходимые для админки
     * 3) App.js, там есть jquery
     * 4) system_script.js - необходимо для админки
     *
     * Данный хелпер функцию необходимо подключать до подключении юзерских стилей и скриптов
     */
    public static function systemSet()
    {
        $arLink=array(
            'system_style'=>'<link rel="stylesheet" href='.asset('system/css/bootstrap.css').'>
                             <link rel="stylesheet" href='.asset('system/css/style.css').'>',

            'script_app'=>'<script defer src='.asset('system/js/app.js').'></script>
                           <scipt  defer src='.asset('system/lib/vue.min.js').'></scipt>
                           <script defer src='.asset('system/js/systems_script.js').'></script>
                           <script defer src='.asset('system/lib/ckeditor.js').'></script>',
        );

        return $arLink['system_style'].$arLink['script_app'];
    }

    /**
     * Данный хелпер ищет в таблице "All_themes" аттрибут "use_theme",
     * который имеет значение true
     *
     * В данный хелпер передается путь до файла
     * Пример:
     *
     * Helper::usingTheme(header)
     *
     * header - фалй (header.blade.php)
     */
    public static function usingTheme($location_file)
    {
        $using_theme=All_themes::where('use_theme',1)->first();
        if(isset($using_theme))
            return 'template.'.$using_theme->name_dir.'.'.$location_file;
        else
            return 'null_template.null_template';
    }

    /**
     * Данная хелпер функция отображает админ панель в шапке сайта
     *
     * Пример:
     * @include(\App\Helpers\Helper::getAdminMenu())
     */
    public static function getAdminMenu()
    {
        return "system.admin_page.head_admin_menu";
    }

    /**
     * Возвращает список контента, в зависимости от того, какие параметры юзер передал ('category') и ('paginate')
     * 'category' - передается id категории (необходимый параметр)
     * 'paginate' - передается пагинация, т.е. сколько отображать выводимых элементов (опциональный параметр)
     * 'orderBy' - сортировка (asc - по алфавиту), (desc - наоборот)
     *
     * Пример:

     * Helper::getListContent(array(
     *       'category'=>34,
     *       'paginate'=>5,
     *       'orderBy'=>'asc'
     *  ));

     */
    public static function getListContent($arStr)
    {
        //Если задан главный параметр 'category'
        if(array_key_exists('category',$arStr))
        {
            //Если юзер указал 'paginate', то выполняется данное условие
            if(array_key_exists('paginate',$arStr))
            {
                $aRSelected_category = Category::where('id',$arStr['category'])->
                                                              where('active',1)->
                                                              first();

                //Если в полученной переменной $aRSelected_category не null,
                // то ищем весь контент, который находится в выбранной категории
                if($aRSelected_category)
                {
                    $aRSelect_content=$aRSelected_category->content()->paginate($arStr['paginate']);
                }
                else
                    dump('getListContent() значение пусто!');
            }
            //Если юзер укзал ещё только 'take', то выполняем это условие
            else
            {
                $aRSelected_category=Category::where('id',$arStr['category'])->
                                                            where('active',1)->
                                                            first();

                //Если в полученной переменной $aRSelected_category не null,
                // то ищем весь контент, который находится в выбранной категории
                if($aRSelected_category)
                {
                    $aRSelect_content=$aRSelected_category->content()->where('active',1)->get();
                }
                else
                    dump('getListContent() значение пусто!');
            }
        }

        return $aRSelect_content;
    }

    /**
     * Возвращает список категорий, зависимости, какаие параметры юзер передал ('paginate')
     * 'paginate' - передается пагинация, т.е. сколько отображать выводимых элементов (опциональный параметр)
     *
     * Пример:
     *
     * Helper::getListCategories(array(
     *         'paginate'=>5
     * ));
     */
    public static function getListCategories($arStr)
    {
        //Если юзер указал 'paginate', то выполняется данное условие
        if(array_key_exists('paginate',$arStr))
        {
            $aRSelected_category=Category::where('active',1)->paginate($arStr['paginate']);
        }
        else
            $aRSelected_category=Category::where('active',1)->get();

        return $aRSelected_category;
    }

    /**
     * Возвращает тот контент, который юзер указал в параметрах
     * 'category' - передается id категории (необходимый параметр)
     * 'content' - передается id контента (необходимый параметр)
     *
     * Пример:
     *
     * Helper::getListCategories(array(
     *         'category'=>5,
     *         'content'=>23
     * ));
     */
    public static function getContent($arStr)
    {
        //Есть ли все необходимые параметры
        $arSelectCategory=null;
        $arSelectContent=null;
        if(array_key_exists('category',$arStr) && array_key_exists('content',$arStr))
        {
            $arSelectCategory=Category::where('id',$arStr['category'])->
                                                    where('active',1)->first();

            if($arSelectCategory)
            {
                $arSelectContent=$arSelectCategory->content()->where('active',1)->first();
            }
        }

        return $arSelectContent;
    }

    /**
     * Данный хелпер возвращает конкретную категорию, которую юхер выбрал
     * Пример:
     * Helper::getCategory(array(
     *          'category'=>2
     * ));
     *
     * Параметры, передаваемые в функцию:
     * category - id категории
     */
    public static function getCategory($array)
    {
        $arCatgory=null;
        if(array_key_exists('category',$array))
        {
            $arCatgory=Category::where('id',$array['category'])->where('active',1)->first();
        }

        return $arCatgory;
    }

    /**
     * данная хелпер функция обрезает текст на столько указал юзер
     * пример:
     * Helper::cutText('какой то текст что откдуа в куда',6,'...')
     *
     * Данный пример показывает, что нужно обрезать текст после 6-ого символа
     * и после 6-ого символа поставить "..."
     *
     * Параметры передаваемые в функцию:
     * $str - любой текст, который введет юзер (обязательно)
     * $number - сколько символов оставить (обязательно)
     * $after - что подставить после обрезанного текст (опционально)
     */
    public static function cutText($str, $numer, $after=null)
    {
        $strResult=substr($str,0,$numer);
        //Если юзер указал, что после обрезанного текста подставить
        if(isset($after))
        {
            //Добвление чего-то после обрезанного текста
            $strResult.=$after;
        }
        return $strResult;
    }

    /**
     * обычно мы пишем:
     * @extend('header')
     *
     * Но с помощью функции хелпера можно просто написать так:
     * @extends(Helper::usingTheme('header'))
     */

    /**
     * данный хелпер получает коллекцию от хелпер функции "getCategory"
     * и выводит весь контент выбранной категории
     * Пример:
     * Helper::getContentFromCategory($var_a)
     *
     * $var_a - коллекция, из запроса "getCategory"
     */
    public static function getContentFromCategory($arStr)
    {
        $arContent=null;
        if($arStr!=null)
        {
            $arContent=$arStr->content()->where('active',true)->get();
        }

        return $arContent;
    }
}
