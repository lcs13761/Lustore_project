<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    
        VerifyEmail::toMailUsing(function($notifiable,$url){
            $displayableActionUrl = str_replace(['mailto:', 'tel:'], '', $url ?? '');
            return (new MailMessage)
            ->subject("Verifique Seu E-mail")
            ->markdown('mail.verifyEmail',["url" => $url,"displayableActionUrl" => $displayableActionUrl]);         
        });

        ResetPassword::toMailUsing(function($notifiable,$url){
            $address = $notifiable instanceof AnonymousNotifiable
        ? $notifiable->routeNotificationFor('mail')
        : $notifiable->email;

        $url = url('/retrieve_password', $url) .  "?email=" . $address;
        $displayableActionUrl = str_replace(['mailto:', 'tel:'], '', $url ?? '');

        return (new MailMessage)
                    ->markdown('mail.resetPassword',
                    ["url" => $url , "displayableActionUrl" => $displayableActionUrl]);
        });
    }
}
