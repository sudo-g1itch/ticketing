<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Aacotroneo\Saml2\Events\Saml2LoginEvent;
use Aacotroneo\Saml2\Events\Saml2LogoutEvent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('Aacotroneo\Saml2\Events\Saml2LoginEvent', function (Saml2LoginEvent $event) {
            
            $messageId = $event->getSaml2Auth()->getLastMessageId();
            
            // Add your own code preventing reuse of a $messageId to stop replay attacks
            $user = $event->getSaml2User();
            $userData = [
                'id' => $user->getUserId(),
                'attributes' => $user->getAttributes(),
                'assertion' => $user->getRawSamlAssertion()
            ];
            dd($userData);
            /**
             * This is the attribute listing and types that are predetermined
             * clearly is following a standard naming for claims
             * "http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress"
             * "http://schemas.xmlsoap.org/ws/2005/05/identity/claims/privatepersonalidentifier"
             * "http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name"
             * "http://schemas.microsoft.com/ws/2008/06/identity/claims/role"
             * "http://schemas.xmlsoap.org/claims/Group"
             * "http://schemas.xmlsoap.org/ws/2005/05/identity/claims/nameidentifier"
             * "http://schemas.xmlsoap.org/claims/CommonName"
            */

            // dd($userData);

            $user = User::where('email', $userData['id'])->first();
            $whetherSubscribedFlag = false;
            $subData = $userData['attributes']['Subscription'];
            foreach($subData as $appData){
                $processedAppData = json_decode($appData);
                if($processedAppData->id == config('app.service_id') && $processedAppData->subdomain == config('app.subdomain')){
                    $whetherSubscribedFlag = true;
                }
            }
            if($whetherSubscribedFlag){
                if($user){
                    Auth::loginUsingId($user->id);
                }else{
             
                    $user = new User;
                    $user->name = $userData['attributes']['http://schemas.xmlsoap.org/claims/CommonName'][0];
                    $user->email = $userData['attributes']['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'][0];
                    // $user->password = $userData['attributes']['PASS_HASH'][0];
                    $user->user_type = $userData['attributes']['http://schemas.microsoft.com/ws/2008/06/identity/claims/role'][0];
                    $user->user_group = $userData['attributes']['http://schemas.xmlsoap.org/claims/Group'][0];
                    $user->save();
    
                    Auth::loginUsingId($user->id);
                }
            }else{
                return redirect('/');
            }
        });

        Event::listen('Aacotroneo\Saml2\Events\Saml2LogoutEvent', function (Saml2LogoutEvent $event) {
            session()->invalidate();
            Auth::logout();
        });
    }
}
