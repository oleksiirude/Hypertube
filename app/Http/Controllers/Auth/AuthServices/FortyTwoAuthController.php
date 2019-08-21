<?php
    
    namespace App\Http\Controllers\Auth\AuthServices;
    
    use Exception;
    use Laravel\Socialite\Facades\Socialite;
    use App\Http\Controllers\Controller;

    class FortyTwoAuthController extends Controller {
    
        protected $helper;
    
        public function __construct() {
            $this->helper = new AuthServicesHelperController();
        }
        
        public function redirectToFortyTwo() {
            return Socialite::driver('42')->redirect();
        }
    
        public function handleFortyTwoCallback() {
            try {
                $data = Socialite::driver('42')->user();
        
                if (!($user = $this->helper->ifUserAlreadyExists($data, '42')))
                    $user = $this->helper->create($data, '42');
    
                $this->helper->login($user);
            } catch (Exception $exception) {
                dd($exception->getMessage());
                // abort(401);
            }
    
            return redirect('main');
        }
    }
