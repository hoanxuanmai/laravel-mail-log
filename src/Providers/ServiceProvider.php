<?php

namespace HXM\LaravelMailLog\Providers;

use \Illuminate\Support\ServiceProvider as IllServiceProvider;
use HXM\LaravelMailLog\Http\Controllers\MailLogController;
use HXM\LaravelMailLog\Listeners\MessageSendingListener;
use HXM\LaravelMailLog\Listeners\MessageSentListener;
use HXM\LaravelMailLog\Models\MailLog;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;

class ServiceProvider extends IllServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/maillog.php', 'maillog');
    }

    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . "/../../database/migrations");

            $this->publishes([
                __DIR__ . '/../../config/maillog.php' => config_path('maillog.php'),
                __DIR__ . '/../../view' => $this->app->resourcePath('views/vendor/maillog')
            ], 'maillog');
        }

        $this->loadViewsFrom(__DIR__ . '/../../view', 'maillog');


        Event::listen(MessageSent::class, MessageSentListener::class);
        Event::listen(MessageSending::class, MessageSendingListener::class);

        $this->registerSchedulePrune();
        $this->registerRoute();
    }


    protected function registerRoute()
    {

        if (!config('maillog.route.enable', true)) return;

        Route::group([
            'domain' => config('maillog.route.domain', null),
            'prefix' => config('maillog.route.prefix', 'mail-logs'),
            'middleware' => config('maillog.route.middleware', ['web']),
            'as' => config('maillog.route.as', 'mail-logs') . "."
        ], function () {
            Route::get('/', [MailLogController::class, 'index'])->name('index');
            Route::get('/{mailLog}', [MailLogController::class, 'show'])->name('show');
            Route::get('/{mailLog}/error', [MailLogController::class, 'error'])->name('error');
        });
    }

    protected function registerSchedulePrune()
    {
        if (!config('maillog.prune.enable', true)) return;

        $this->app->afterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->call(function () {
                MailLog::whereDate('created_at', '<', now()->subDays((int) config('maillog.prune.days', 30)))->delete();
            })->daily();
        });
    }
}
