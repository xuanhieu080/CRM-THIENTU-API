<?php

namespace App\Jobs;

use App\Mail\NotifyMail;
use App\Supports\FORUM;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $details;

    /**
     * Create a new job instance.
     *
     * @param $details
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $mailer = $this->details['mailer'];
            Config::set('mail.from.address',$this->details['email_address']);
            Config::set('mail.from.name',\config("mail.mailers.$mailer.MAIL_FROM_NAME"));
            $email = new NotifyMail($this->details);
            Mail::mailer($mailer)->to($this->details['to'])->send($email);
        } catch (\Exception $ex) {
            $data = [
                'action'  => 'ERROR',
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'null',
                //            'browser' => "Parent: $parent - Platform: $platform - Browser: $browser",
                'link'    => url()->current(),
                'time'    => date("Y-m-d H:i:s", time()),
                'file'    => $ex->getFile(),
                'line'    => $ex->getLine(),
                'error'   => $ex->getMessage(),
            ];

            \Illuminate\Support\Facades\Log::info($data);
        }
    }

}
