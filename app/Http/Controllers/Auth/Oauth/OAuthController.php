<?php
    
    namespace App\Http\Controllers\Auth\Oauth;
    
    use App;
    use App\User;
    use Exception;
    use Hash;
    use Laravel\Socialite\Facades\Socialite;
    use App\Http\Controllers\Controller;
    
    class OAuthController extends Controller {
        
        
        public function redirectToProvider($provider) {
            try {
                $socialite = Socialite::driver($provider);
                return $socialite->redirect();
            } catch (Exception $exception) {
                dd($exception->getMessage());
                // abort(401);
            }
        }
        
        public function handleProviderCallback($provider) {
            try {
                $data = Socialite::driver($provider)->user();
                
                if (!($user = $this->ifUserAlreadyExists($data, $provider)))
                    $user = $this->create($data, $provider);
                
                $this->login($user);
            } catch (Exception $exception) {
                dd($exception->getMessage());
                // abort(401);
            }
            
            return redirect('main');
        }
    
        public function ifUserAlreadyExists($data, $provider) {
            $id = $data->getId();
        
            $user = User::where([
                'auth_provider' => $provider,
                'auth_provider_id' => $id
            ])->first();
        
            return $user ? $user : false;
        }
    
    
        public function create($data, $provider) {
            $uuid = $this->getNewUuidForUserTable();
            $login = $this->specifyLogin($data->getNickname());
            $name = $this->specifyName($data->getName());
            $email = $this->handleEmailDublicate($data->getEmail());
            $avatar = $this->handleCopyAvatar($data->getAvatar(), $login);
        
            if (!$email['result'])
                exit (view('auth.error',
                    [
                        'title' => trans('constant.login') . trans("constant.via") . trans("constant.$provider"),
                        'error' => trans('constant.email') . " $email[email]" . trans('constant.already_taken')
                    ])
                );
        
            return User::create([
                'uuid' => $uuid,
                'login' => $login,
                'first_name' => ucfirst($name[0]),
                'last_name' => ucfirst($name[1]),
                'avatar' => $avatar,
                'email' => strtolower($data->getEmail()),
                'password' => Hash::make(str_shuffle($uuid)),
                'auth_provider' => $provider,
                'auth_provider_id' => (string)$data->getId()
            ]);
        }
    
        public function specifyLogin($login) {
            if ($login) {
                if (!User::where('login', $login)->first())
                    return $login;
                else
                    while (true) {
                        $login = $login . str_shuffle('0123456789');
                        if (!User::where('login', $login)->first())
                            return $login;
                    }
            }
            else
                while (true) {
                    $login = 'user' . str_shuffle('0123456789');
                    if (!User::where('login', $login)->first())
                        return $login;
                }
        }
    
        public function specifyName($name) {
            if ($name) {
                $name = explode(' ', $name);
                if (!isset($name[1]))
                    $name[] = 'Surname';
            } else {
                $name[] = 'Name';
                $name[] = 'Surname';
            }
            return $name;
        }
    
        public function handleEmailDublicate($email) {
        
            if (User::where('email', $email)->first())
                return ['result' => false, 'email' => $email];
            return ['result' => true, 'email' => $email];
        }
    
        public function handleCopyAvatar($avatar, $login) {
            if (!$avatar)
                return 'images/service/default.png';
            else {
                if (!file_exists(public_path() . '/images/profiles'))
                    mkdir(public_path() . '/images/profiles');
                if (!file_exists(public_path() . '/images/profiles/' . $login))
                    mkdir(public_path() . '/images/profiles/' . $login);
                if (!copy($avatar,public_path() . '/images/profiles/' . $login . '/avatar.jpg')) {
                    rmdir(public_path() . '/images/profiles/' . $login);
                    return 'images/service/default.png';
                }
            }
            return 'images/profiles/' . $login . '/avatar.jpg';
        }
    
        public function login($user) {
            $locale = session()->get('locale');
            auth()->login($user);
            App::setLocale($locale);
            session()->put('locale', $locale);
        }
    }