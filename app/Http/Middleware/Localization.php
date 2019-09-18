<?php

    namespace App\Http\Middleware;
    
    use Closure;
    use App\User;
    use Illuminate\Support\Facades\App;

    class Localization
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {
            $user = User::find(auth()->id());
      
            if ($user) {
                session()->put('locale', $user->lang);
                App::setLocale($user->lang);
            } else
                if (session()->has('locale'))
                    App::setLocale(session()->get('locale'));
                else
                    App::setLocale('en');
            
            return $next($request);
        }
    }
