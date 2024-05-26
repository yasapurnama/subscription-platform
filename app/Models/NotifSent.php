<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifSent extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'email_subscription_id',
    ];
}
