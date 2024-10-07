<?php

namespace HXM\LaravelMailLog\Mail;

use Exception;
use HXM\LaravelMailLog\Actions\SaveMailLog;
use HXM\LaravelMailLog\Exceptions\SendSwiftMessageException;

class Mailer extends \Illuminate\Mail\Mailer
{
    public function send($view, array $data = [], $callback = null)
    {
        try {

            return parent::send($view, $data, $callback);
        } catch (SendSwiftMessageException $exception) {

            if (config('maillog.send_swift_message.save_error', true) || config('maillog.send_message.save_error', true)) {
                SaveMailLog::error($exception);
            }

            if (config('maillog.send_swift_message.throw_exception')) {
                throw $exception->getPrevious();
            }
        } catch (Exception $exception) {

            if (config('maillog.send_message.save_error', true)) {
                SaveMailLog::error($exception);
            }

            if (config('maillog.send_message.throw_exception')) {
                throw $exception;
            }
        }
    }

    protected function sendSwiftMessage($message)
    {
        $this->failedRecipients = [];

        try {

            return $this->swift->send($message, $this->failedRecipients);
        } catch (Exception $exception) {

            throw new SendSwiftMessageException($exception->getMessage(), 0, $exception);
        } finally {

            $this->forceReconnection();
        }
    }
}
