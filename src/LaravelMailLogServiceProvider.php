<?php

namespace HXM\LaravelMailLog;

use \Illuminate\Support\ServiceProvider;
use HXM\LaravelMailLog\Listeners\MessageSentListener;
use HXM\LaravelMailLog\Listeners\MessageSendingListener;
use HXM\LaravelMailLog\Models\MailLog;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Container\Container;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;

class LaravelMailLogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/../migrations");

        Event::listen(MessageSent::class, MessageSentListener::class);
        Event::listen(MessageSending::class, MessageSendingListener::class);
        $this->app->afterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->call(function () {
                MailLog::whereDate('created_at', '<', now()->subMonths())->delete();
            })->daily();
        });
    }
    public function register() {}
}
