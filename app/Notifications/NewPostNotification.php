<?php

namespace App\Notifications;

use App\Models\EmailSubscription;
use App\Models\NotifSent;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class NewPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected object $post)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        $sentMessage = Mail::raw('New post: ' . $this->post->title, function ($message) use ($notifiable) {
            $message->to($notifiable->routes['email'])
                ->subject('[New Post] ' . $this->post->title)
                ->html($this->post->content);
        });

        if ($sentMessage) {
            $emailSubscription = EmailSubscription::where('email', $notifiable->routes['email'])->first();
            NotifSent::create([
                'post_id' => $this->post->id,
                'email_subscription_id' => $emailSubscription->id,
            ]);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
