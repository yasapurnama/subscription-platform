<?php

namespace App\Models;

use App\Notifications\NewPostNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'title',
        'content',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function (Post $post) {
            $post->website->subscribers->each(fn (Subscriber $subscriber) =>
                Notification::route('email', $subscriber->emailSubscription->email)
                    ->notify(new NewPostNotification($post))
            );
        });
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function notifSents()
    {
        return $this->hasMany(NotifSent::class);
    }
}
