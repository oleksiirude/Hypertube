<?php

    namespace App\Providers;
    
    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\Schema;
    
    class AppServiceProvider extends ServiceProvider {
        /**
         * Register any application services.
         *
         * @return void
         */
        public function register() {
            //
        }
    
        /**
         * Bootstrap any application services.
         *
         * @return void
         */
        public function boot() {
            Schema::defaultStringLength(191);
            
            $this->boot42Socialite();
        }
    
        private function boot42Socialite()
        {
            $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
            $socialite->extend(
                '42',
                function ($app) use ($socialite) {
                    $config = $app['config']['services.42'];
                    return $socialite->buildProvider(FortyTwoOAuthProvider::class, $config);
                }
            );
        }
    }
