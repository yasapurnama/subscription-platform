<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'email_subscription_id',
    ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function emailSubscription()
    {
        return $this->belongsTo(EmailSubscription::class);
    }
}
