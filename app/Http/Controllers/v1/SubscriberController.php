<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriberRequest;
use App\Models\EmailSubscription;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Http\Response;

class SubscriberController extends Controller
{
    public function store(StoreSubscriberRequest $request)
    {
        $subscriber = Subscriber::where('website_id', $request->website_id)
            ->whereHas('emailSubscription', function ($query) use ($request) {
                $query->where('email', $request->email);
            })
            ->first();

        if ($subscriber) {
            return response()->json(null, Response::HTTP_CONFLICT);
        }


        $emailSubscription = EmailSubscription::where('email', $request->email)->first();

        if (!$emailSubscription) {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $emailSubscription = $user->emailSubscription()->firstOrCreate(['email' => $request->email]);
            } else {
                $emailSubscription = EmailSubscription::create(['email' => $request->email]);
            }
        }

        Subscriber::create([
            'website_id' => $request->website_id,
            'email_subscription_id' => $emailSubscription->id,
        ]);

        return response()->json(null, Response::HTTP_CREATED);
    }
}
