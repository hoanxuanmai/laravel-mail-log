<?php

namespace HXM\LaravelMailLog\Listeners;

use HXM\LaravelMailLog\Actions\SaveMailLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSending;

class MessageSendingListener
{

    public function handle(MessageSending $event)
    {
        SaveMailLog::execute($event->message, false);
    }
}
