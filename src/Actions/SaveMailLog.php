<?php

namespace HXM\LaravelMailLog\Actions;

use Exception;
use HXM\LaravelMailLog\Models\MailLog;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SaveMailLog
{
    /**
     * Summary of processingIntance
     * @var MailLog|null
     */
    protected static $processingIntance;

    public static $throwException = true;

    static function execute(\Swift_Message $swift_Message, bool $status)
    {
        $instance = MailLog::updateOrCreate(
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

        if (!$status) {
            static::$processingIntance = $instance;
        } else {
            static::$processingIntance = null;
        }
    }

    static function error(Exception $exception)
    {

        if (static::$processingIntance) {
            static::$processingIntance->error()->create([
                'message' => Str::substr($exception->getMessage(), 0, Schema::getFacadeRoot()::$defaultStringLength),
                'trace' => Str::substr($exception->getMessage() . PHP_EOL . $exception->getTraceAsString(), 0, pow(2, 16) - 1),
            ]);
        }
    }
}
