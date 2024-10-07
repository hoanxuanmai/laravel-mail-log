<?php

namespace HXM\LaravelMailLog\Models;

use Illuminate\Database\Eloquent\Model;

class MailError extends Model
{
    protected $table = "hxm_mail_errors";
    
    protected $fillable = ['message', 'trace'];

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;
}
