<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Page503;
use App\View\Components\ErrorValidationMessage;
use App\View\Components\SuccessMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('page-503', Page503::class);
        Blade::component('error-validation-message', ErrorValidationMessage::class);
        Blade::component('success-message', SuccessMessage::class);
    }
}
