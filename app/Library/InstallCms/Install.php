<?php

namespace App\Library\InstallCms;

use App\Models\All_themes;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Install
{
    public static function getAccessDb($key)
    {
        //Получаем путь до файла "db_access.json"
        $path=static::getPath();
        $content = json_decode(file_get_contents($path), true);

        return $content[$key];
    }

    public static function setAccessDb($new_request)
    {
        config(['database.connections.mysql.host'=>$new_request['db_host']? $new_request['db_host']: '127.0.0.1']);
        config(['database.connections.mysql.port'=>$new_request['db_port']? $new_request['db_port']: '3306']);
        config(['database.connections.mysql.database'=>$new_request['name_db']]);
        config(['database.connections.mysql.username'=>$new_request['login_db']]);
        config(['database.connections.mysql.password'=>$new_request['db_password']]);

        \Artisan::call('migrate');

        //Получаем путь до файла "db_access.json"
        $path=static::getPath();
        $content = json_decode(file_get_contents($path), true);

        $content['DB_HOST'] = $new_request['db_host']? $new_request['db_host']: "127.0.0.1";
        $content['DB_PORT'] = $new_request['db_port']? $new_request['db_port']: "3306";
        $content['DB_DATABASE'] = $new_request['name_db'];
        $content['DB_USERNAME'] = $new_request['login_db'];
        $content['DB_PASSWORD'] = key_exists('db_password',$new_request)? $new_request['db_password']: "";
        $content['DB_INSTALLED'] = true;

        file_put_contents($path, json_encode($content));
    }

    /**
     * отображает путь до проекта
     */
    public static function getPath()
    {
        return base_path('db_access.json');
    }

    public static function setDefaultTheme()
    {
        $path=resource_path('/views/template/default_theme/description.json');
        $content=json_decode(file_get_contents($path), true);

        $all_theme = new All_themes;
        $all_theme->name_dir = 'default_theme';
        $all_theme->name_theme = $content['theme'];
        $all_theme->name_author = $content['author'];
        $all_theme->description_theme = $content['desc'];
        $all_theme->use_theme = true;

        $all_theme->save();
    }

    /**
     * Регистрирует юзера после установки cms
     * @param $new_request - $request->except('_token')
     */
    public static function installRegistrationUser($new_request)
    {
        $user=new User();
        $user->login=$new_request['login_registration'];
        $user->email=$new_request['email'];
        $user->password=\Hash::make($new_request['password']);
        $user->active=true;
        $user->main_user=true;

        $user->save();

        $role=new Role();
        $role->name='admin';
        $role->super_user=true;
        $role->access_admin_page=true;
        $role->access_content=true;
        $role->access_security=true;
        $role->access_setting=true;
        $role->access_to_create=true;
        $role->access_to_edit=true;
        $role->access_to_delete=true;

        $role->save();

        $user=User::find($user->id);
        $role_id=Role::max('id');

        $user->roles()->attach($role_id);

        \Auth::loginUsingId(User::max('id'));
    }

    public static function setDefaultContent()
    {
        //Вставка значений в таблицу "categories"
        DB::insert('INSERT INTO `categories` (`id`, `name`, `active`,`super_category`,`parent_id`, `user_id`, `created_at`, `updated_at`) VALUES
        (1, \'title of banner\', 1, 1, null, 1, \'2020-02-26 14:08:06\', \'2020-02-26 14:08:06\'),
        (2, \'first_block\', 1, 1, null, 1, \'2020-02-26 14:09:13\', \'2020-02-26 14:09:13\'),
        (3, \'second_block\', 1, 1, null, 1, \'2020-02-26 14:09:30\', \'2020-02-26 14:09:30\'),
        (4, \'Quotes of great men\', 1, 1, null, 1, \'2020-02-26 14:10:41\', \'2020-02-26 14:10:41\')');

        //Вставка данных в таблицу "contents"
        DB::insert('INSERT INTO `contents` (`id`, `title`, `content`, `active`, `user_id`, `created_at`, `updated_at`) VALUES
        (1, \'title on banner\', \'<p>there is some much text!</p>\', 1, 1, \'2020-02-26 14:08:41\', \'2020-02-26 14:08:41\'),
        (2, \'title\', \'<p>text on first block</p>\', 1, 1, \'2020-02-26 14:09:54\', \'2020-02-26 14:09:54\'),
        (3, \'title\', \'<p>text on second block</p>\', 1, 1, \'2020-02-26 14:10:11\', \'2020-02-26 14:10:11\'),
        (4, \'Tomorow day\', \'<p>And today, tomorrow, not everyone can watch. Rather, not only everyone can watch. Few can do it</p>\', 1, 1, \'2020-02-26 14:11:34\', \'2020-02-26 14:11:34\'),
        (5, \'5 years\', \'<p>Give me five years and you will not recognize Germany</p>\', 1, 1, \'2020-02-26 14:12:18\', \'2020-02-26 14:12:18\'),
        (6, \'State\', \'<p>everything for the state is nothing outside the state</p>\', 1, 1, \'2020-02-26 14:12:52\', \'2020-02-26 14:12:52\')');

        //Вставка значений в таблицу "category_content"
        Db::insert('INSERT INTO `category_content` (`id`, `category_id`, `content_id`) VALUES
        (1, 1, 1),
        (2, 2, 2),
        (3, 3, 3),
        (4, 4, 4),
        (5, 4, 5),
        (6, 4, 6)');

        //Вставка значкний в таблицу "list_additional_properties"
        DB::insert('INSERT INTO `list_additional_properties` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
        (1, \'строка\', \'input\', NULL, NULL),
        (2, \'поле\', \'textarea\', NULL, NULL)');
    }
}
