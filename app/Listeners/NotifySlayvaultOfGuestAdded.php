<?php

namespace App\Listeners;

use App\Events\GuestCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

use Log;

class NotifySlayvaultOfGuestAdded
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\GuestCreated  $event
     * @return void
     */
    public function handle(GuestCreated $event)
    {   
        $client = $event->client;
        $token = base64_decode($client->owner->sv_token);
        $c_uuid = $client->owner->c_uuid;

        $response = Http::withToken($token)->post('http://slayvault.saaslay.test/api/create-client/'.$c_uuid, 
            [
                'name' => $client->name,
                'uuid' => $client->uuid,
            ]
        );

        Log::debug($response);
    }
}
