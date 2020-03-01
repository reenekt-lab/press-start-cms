<?php

namespace App\Http\Controllers\UserController\ControllerWithHelper;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        //Постер
        $arResult=Helper::getContent(array(
            'category'=>1,
            'content' =>1
        ));

        //Два блока под постером
        //Выбирает данные из первого блока
        $arCategoryFirstBlock=Helper::getCategory(array(
            'category'=>2
        ));

        //Получает контентиз полученной категории "$arCategoryFirstBlock"
        $arContentFirstBlock=Helper::getContentFromCategory($arCategoryFirstBlock);

        //Выбирает данные из первого блока
        $arCategorySecondBlock=Helper::getCategory(array(
            'category'=>3
        ));

        //Получает контентиз полученной категории "$arCategoryFirstBlock"
        $arContentSecondBlock=Helper::getContentFromCategory($arCategorySecondBlock);

        $arContentSecondBlock=Helper::getContentFromCategory($arCategorySecondBlock);

        //Отображает контент из категории "Цитаты великих людей"
        $arGreatePeople=Helper::getCategory(array(
            'category'=>4
        ));

        $arContent=Helper::getContentFromCategory($arGreatePeople);

        return view(Helper::usingTheme('index'), compact(
            'arResult',
                  'arCategoryFirstBlock',
                    'arContentFirstBlock',
                    'arCategorySecondBlock',
                    'arContentSecondBlock',
                    'arGreatePeople',
                    'arContent'));
    }
}
