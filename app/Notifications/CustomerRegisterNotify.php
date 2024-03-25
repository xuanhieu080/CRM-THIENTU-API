<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use NotificationChannels\Telegram\TelegramMessage;

class CustomerRegisterNotify extends Notification
{
    use Queueable;

    protected $service;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ["telegram"];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $company
     * @return array
     */
    public function toTelegram($customer)
    {
        $time = Carbon::parse($customer->created_at)->format('d/m/y H:i:s');

        $service = $this->service;
        $content = "$customer->name vừa đăng ký gói $service->name _
_Thời gian: $time
";
        return TelegramMessage::create()
            ->to(env('TELEGRAM_CUSTOMER_REGISTER', '-1002068564873'))
            ->content($content);
    }
}
