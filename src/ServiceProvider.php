<?php

namespace Armincms\MDarman;

use Armincms\Orderable\Events\OrderVerified;
use Armincms\Koomeh\Models\KoomehProperty;
use Armincms\Koomeh\Models\KoomehPromotion;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Laravel\Nova\Nova as LaravelNova;
use Zareismail\Gutenberg\Gutenberg;

class ServiceProvider extends AuthServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/config.php', 'mdarman');
        $this->routes();
    }


    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        \Route::middleware(['auth:sanctum'])->get('mdarman/courses/{course}/subscribe', [
            'as' => 'mdarman.subscribe',
            'uses' => Http\Controllers\SubscribeController::class,
        ]);

        \Route::middleware([/*'auth:sanctum'*/])->get('mdarman/courses/{course}/subscribed', [
            'as' => 'mdarman.subscribed',
            'uses' => Http\Controllers\SubscribeController::class.'@subscribed',
        ]);
    }
}
