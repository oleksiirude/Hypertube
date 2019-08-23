<?php
    
    /*
    |--------------------------------------------------------------------------
    | SendRecoverPasswordEmail
    |--------------------------------------------------------------------------
    | push sendRecoverPasswordNotification in a queue
    */
    
    namespace App\Notifications;
    
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
    
    class SendRecoverPasswordEmail extends ResetPasswordNotification implements ShouldQueue 
    {
        use Queueable;
    }