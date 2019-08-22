<?php
    
    namespace App\Providers;
    
    use Arr;
    use Laravel\Socialite\Two\AbstractProvider;
    use Laravel\Socialite\Two\ProviderInterface;
    use Laravel\Socialite\Two\User;
    
    class FortyTwoOAuthProvider extends AbstractProvider implements ProviderInterface {
        
        protected function getAuthUrl($state) {
            return $this->buildAuthUrlFromBase('https://api.intra.42.fr/oauth/authorize', $state);
        }
        
        protected function getTokenUrl() {
            return 'https://api.intra.42.fr/oauth/token';
        }
        
        protected function getTokenFields($code) {
            return Arr::add(
                parent::getTokenFields($code), 'grant_type', 'authorization_code'
            );
        }
        
        protected function getUserByToken($token) {
            $response = $this->getHttpClient()->get('https://api.intra.42.fr/v2/me', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);
            return json_decode($response->getBody(), true);
        }
    
        protected function mapUserToObject(array $user) {
            return (new User)->setRaw($user)->map([
                'id' => $user['id'],
                'nickname' => $user['login'],
                'name' => $user['displayname'],
                'email' => $user['email'],
                'avatar' => $user['image_url']
            ]);
        }
    }
