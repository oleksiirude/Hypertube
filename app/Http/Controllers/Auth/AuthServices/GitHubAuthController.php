<?php
    
    namespace App\Http\Controllers\Auth\AuthServices;
    
    use Exception;
    use App\Http\Controllers\Controller;
    use Laravel\Socialite\Facades\Socialite;

    class GitHubAuthController extends Controller {
        
        protected $helper;
        
        public function __construct() {
            $this->helper = new AuthServicesHelperController();
        }
        
        public function redirectToGitHub() {
            return Socialite::driver('github')->redirect();
        }
    
        public function handleGitHubCallback() {
            try {
                $data = Socialite::driver('github')->user();
                
                if (!($user = $this->helper->ifUserAlreadyExists($data, 'github')))
                    $user = $this->helper->create($data, 'github');
    
                $this->helper->login($user);
            } catch (Exception $exception) {
                dd($exception->getMessage());
                // abort(401);
            }
    
            return redirect('main');
        }
    }
