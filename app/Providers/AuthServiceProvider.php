<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use App\Policies\System\SecurityPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Достпу к админ странице
        Gate::define('access_admin_page', function ($user)
        {
            foreach ($user->roles as $allRole) {
                if ($allRole->access_admin_page == true) {
                    return true;
                }
            }
            return false;
        });

        //Доступ к разделу "Контент" в админ странице
        Gate::define('access_content', function ($user)
        {
            foreach ($user->roles as $allRole) {
                if ($allRole->access_content == true) {
                    return true;
                }
            }
            return false;
        });

        //Доступ к разделу "Политика безопасности" в админ странице
        Gate::define('access_security', function ($user)
        {
            foreach ($user->roles as $allRole) {
                if ($allRole->access_security == true) {
                    return true;
                }
            }
            return false;
        });

        //Доступ к разделу "Настройки" в админ странице
        Gate::define('access_setting', function ($user)
        {
            foreach ($user->roles as $allRole) {
                if ($allRole->access_setting == true) {
                    return true;
                }
            }
            return false;
        });

        //Доступ к созданию
        Gate::define('access_to_create', function ($user)
        {
            foreach ($user->roles as $allRole) {
                if ($allRole->access_to_create == true) {
                    return true;
                }
            }
            return false;
        });

        //Доступ к редактированию
        Gate::define('access_to_edit', function ($user)
        {
            foreach ($user->roles as $allRole) {
                if ($allRole->access_to_edit == true) {
                    return true;
                }
            }
            return false;
        });

        //Доступ к удалению
        Gate::define('access_to_delete', function ($user)
        {
            foreach ($user->roles as $allRole) {
                if ($allRole->access_to_delete == true) {
                    return true;
                }
            }
            return false;
        });
    }
}
