<?php

namespace HXM\LaravelMailLog\Listeners;

use HXM\LaravelMailLog\Actions\SaveMailLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSent;

class MessageSentListener
{
    public function handle(MessageSent $event)
    {
        SaveMailLog::execute($event->message, true);
    }
}
