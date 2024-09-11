<?php

namespace HXM\LaravelMailLog\Actions;

use HXM\LaravelMailLog\Models\MailLog;

class SaveMailLog
{
    static function execute(\Swift_Message $swift_Message, bool $status)
    {
        MailLog::updateOrCreate(
            [
                'id' => $swift_Message->getBoundary(),
            ],
            [
                'from' => $swift_Message->getFrom(),
                'to' => $swift_Message->getTo(),
                'cc' => $swift_Message->getCc(),
                'bcc' => $swift_Message->getBcc(),
                'subject' => $swift_Message->getSubject(),
                'body' => $swift_Message->getBody(),
                'status' => $status,
            ]
        );
    }
}
