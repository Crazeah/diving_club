<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationCancelled extends Notification
{
    use Queueable;

    protected $registration;

    /**
     * Create a new notification instance.
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
     public function toMail(object $notifiable): MailMessage
    {
        $activity = $this->registration->activity;
        
        return (new MailMessage)
            ->subject('您的活動報名已取消')
            ->greeting('您好，' . $notifiable->name)
            ->line('我們收到您取消參加以下活動的請求：')
            ->line($activity->title)
            ->line('您的報名已成功取消。')
            ->line('若此為系統錯誤或您並未申請取消，請立即聯繫我們的客服人員。')
            ->action('查看其他活動', url('/activities'))
            ->line('感謝您的支持與理解！');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $activity = $this->registration->activity;
        
        return [
            'activity_id' => $activity->id,
            'activity_title' => $activity->title,
            'type' => 'registration_cancelled',
            'message' => '您已成功取消參加活動「' . $activity->title . '」的報名。'
        ];
    }
}