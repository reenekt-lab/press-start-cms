<?php

namespace App\Providers;

use App\Models\All_themes;
use App\Models\SystemSettings;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $defaultTheme = 'default_theme';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $provider = $this;
        \Illuminate\View\View::macro('theme', function (string $theme = null) use ($provider) {
            if (!$theme) {
                $theme = $provider->getThemeFromSettings();
            }
            /** @var \Illuminate\View\View $view */
            $view = $this;

            if (!view()->exists($theme . '.' . $view->name())) {
                return $view;
            }
            return  view($theme . '.' . $view->name(), $view->getData());
        });
    }

    public function getThemeFromSettings(): string
    {
        $theme = $this->defaultTheme;

        /** @var SystemSettings|null $settings */
//        $settings = SystemSettings::where(['name' => 'theme'])->first();
        $user_theme = All_themes::where(['use_theme',1])->first();
        if ($user_theme) {
            return $user_theme->name_dir;

//            $theme = $settings->value['name'];
        }
//        if ($settings) {
//            $theme = $settings->value['name'];
//        }

        return $theme;
    }
}
