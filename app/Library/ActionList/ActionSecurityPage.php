<?php

namespace App\Library\ActionList;

use App\Models\User;

class ActionSecurityPage
{
    public static function actionList($newRequest)
    {
        //Создаем массив, который будет хранить все checkbox
        $arRequestCheckbox = [];
        $input=[];

        $action=$newRequest['option_action'];

        //Запихиваем в массив $input все выбранные элементы
        foreach ($newRequest as $key=>$value)
        {
            if($key!='option_action')
            {
                $input[$key]=$value;
            }
        }

        //Проходим по всему $input с целью разделить checkbox_3 на [checkbox][3]
        //и запихиваем число в заранее созданный массив
        foreach ($input as $key=>$value)
        {
            $pieces = explode("_", $key);
            array_push($arRequestCheckbox,$pieces[1]);
        }

        if($action=='Активировать')
        {
            foreach ($arRequestCheckbox as $arItem)
            {
                User::where('id',$arItem)->update(['active'=>true]);
            }
        }
        elseif($action=='Деактивировать')
        {
            foreach ($arRequestCheckbox as $arItem)
            {
                if($arItem!=1)
                    User::where('id',$arItem)->update(['active'=>false]);
            }
        }
        else
        {
            $super_user=0;
            //Если юзер выбрал из списка "Удалить"
            foreach ($arRequestCheckbox as $arItem)
            {
                //Ищет строку с заданным id в User
                $user = User::find($arItem);

                //Отображает все роли выбранного юзера
                foreach ($user->roles as $value)
                {
                    if($value->super_user==true)
                    {
                        $super_user=1;
                        continue;
                    }else
                    {
                        //Удаляет все строки в связанной таблице, которой что то там
                        $user->roles()->detach($value->id);
                        $super_user=0;
                    }
                }
                if(!$super_user)
                {
                    //Удаляет строку в таблице User по заданному id
                    User::destroy($arItem);
                }
            }
        }
    }
}
