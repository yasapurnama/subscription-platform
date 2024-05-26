<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Subscriber;
use App\Notifications\NewPostNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notifications to all subscribers.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = Post::with('website.subscribers.emailSubscription')
            ->whereDoesntHave('notifSents')
            ->get();

        foreach ($posts as $post) {
            $post->website->subscribers->each(fn (Subscriber $subscriber) =>
                Notification::route('email', $subscriber->emailSubscription->email)
                    ->notify(new NewPostNotification($post))
            );
        }
    }
}
