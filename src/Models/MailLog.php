<?php

namespace HXM\LaravelMailLog\Models;

use Illuminate\Database\Eloquent\Model;

class MailLog extends Model
{
    protected $table = "hxm_mail_logs";
    protected $fillable = ['id', 'from', 'to', 'cc', 'bcc', 'subject', 'body', 'status'];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'from' => 'array',
        'to' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
        'status' => 'bool',
    ];

    function error()
    {
        return $this->hasOne(MailError::class, 'id', 'id');
    }
}
