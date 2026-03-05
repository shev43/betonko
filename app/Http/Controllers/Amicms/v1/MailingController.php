<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Mail\Subscribe;
use Mail;
use Illuminate\Http\Request;

class MailingController extends AmicmsController {
    public function index() {
        return view('emails.subscribe');
    }

    public function store() {

        $options = array(
            'unsubscribe_url'   => 'http://mysite.com/unsub',
            'play_url'          => 'http://google-play.com/myapp',
            'ios_url'           => 'http://apple-store.com/myapp',
            'sendfriend_url'    => 'http://mysite.com/send_friend',
            'webview_url'       => 'http://mysite.com/webview_url',
            'invoice_id'       => 'invoice_id',
            'invoice_total'       => 'invoice_total',
            'download_link'       => 'download_link',
        );
        Mail::to('info@art-delight.com')
            ->locale('uk')
            ->send(new Subscribe($options));

        if (Mail::failures()) {
            return ('Sorry! Please try again latter');
        }else{
            return ('Great! Successfully send in your mail');
        }
    }
}
