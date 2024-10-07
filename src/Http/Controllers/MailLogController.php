<?php

namespace HXM\LaravelMailLog\Http\Controllers;

use App\Models\Post;
use HXM\LaravelMailLog\Models\MailLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MailLogController extends Controller
{
    function index()
    {
        $list = MailLog::withCount('error')->latest()->paginate();

        return view('maillog::index', compact('list'));
    }

    function show(MailLog $mailLog)
    {
        return $mailLog->body;
    }
    function error(MailLog $mailLog)
    {
        echo '<pre>';
        echo optional($mailLog->error)->trace;
        echo '</pre>';
    }
}
