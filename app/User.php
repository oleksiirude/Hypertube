<?php
    
    namespace App;
    
    use App\Notifications\SendRecoverPasswordEmail;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    
    class User extends Authenticatable {
        use Notifiable;
    
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'uuid', 'login', 'first_name', 'last_name', 'avatar', 'email', 'password', 'auth_provider', 'auth_provider_id'
        ];
        
        protected $primaryKey = 'uuid';
        
        /**
         * Turn off default casting [id] to int type
         */
        public $incrementing = false;
        
        /**
         * Overrides default method sendPasswordResetNotification Illuminate/Auth/Passwords/CanResetPassword
         *
         * @param  string  $token
         */
        public function sendPasswordResetNotification($token) {
            $this->notify(new SendRecoverPasswordEmail($token));
        }
        
    }
