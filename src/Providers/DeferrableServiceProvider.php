<?php

namespace HXM\LaravelMailLog\Providers;

use HXM\LaravelMailLog\Mail\MailManager;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DeferrableServiceProvider extends ServiceProvider implements DeferrableProvider
{
    function register()
    {
        $this->app->singleton('mail.manager', function ($app) {
            return new MailManager($app);
        });
    }

    function provides()
    {
        return [
            'mail.manager'
        ];
    }
}
