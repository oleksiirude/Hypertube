<?php

    namespace App\Http\Controllers;
    
    use Auth;
    use App\User;
    use Validator;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    
    class ProfileController extends Controller
    {
        private $user;
        
        public function __construct()
        {
            $this->middleware(function($request, $next)
            {
               $this->user = User::find(Auth::id());
               return $next($request);
            });
        }
    
        protected function showAuthProfile()
        {
            return view('profiles.auth-profile', [
                'profile' => User::find(auth()->id()),
                'wishlist' => WishlistController::getWishlist($this->user->uuid),
                'history' => HistoryController::getHistory($this->user->uuid),
                'recommendations' => RecommendationsController::getRecommendations($this->user->uuid),
                'property' => RecommendationsController::getProperty($this->user->uuid)
            ]);
        }
        
        protected function showUserProfile($login)
        {
            $user = User::where('login', $login)->firstOrFail();
            
            if ($user->uuid === auth()->user()->uuid)
                return redirect()->route('show.auth');
            
            return view('profiles.user-profile', [
                'profile' => $user,
                'recommendations' => RecommendationsController::getRecommendations($user->uuid),
                'property' => RecommendationsController::getProperty($user->uuid)
            ]);
        }
        
        protected function changeLogin(Request $request)
        {
            $validation = Validator::make($request->all(), [
                'login' => 'required|unique:users|regex:/^[a-z]{3,20}[0-9]{0,10}?$/i'
            ]);
            
            if ($validation->fails())
                return $this->jsonResponseWithError($validation->errors()->first());
            
            $newLogin = $request->get('login');
            
            if($this->user->avatar !== DEFAULT_AVATAR) {
                $this->user->update([
                    'avatar' => PATH_TO_PROFILE . $newLogin . AVATAR
                ]);
            }
            
            $this->renameDir(auth()->user()->login, $newLogin);
            $this->user->update(['login' => $newLogin]);
            return response()->json(['result' => true]);
        }
        
        protected function changeInfo(Request $request)
        {
            $validation = Validator::make($request->all(), [
                'info' => 'max:500'
            ]);
    
            if ($validation->fails())
                return $this->jsonResponseWithError($validation->errors()->first());
    
            $this->user->update(['info' => $request->get('info')]);
            return response()->json(['result' => true]);
        }
        
        protected function changeFirstName(Request $request)
        {
            $validation = Validator::make($request->all(), [
                'first_name' => 'required|regex:/^[a-zа-яёїі]{2,20}$/iu'
            ]);
    
            if ($validation->fails())
                return $this->jsonResponseWithError($validation->errors()->first());
    
            $this->user->update(['first_name' => $request->get('first_name')]);
            return response()->json(['result' => true]);
        }
    
        protected function changeLastName(Request $request)
        {
            $validation = Validator::make($request->all(), [
                'last_name' => 'required|regex:/^[a-zа-яёїі]{2,20}$/iu'
            ]);
    
            if ($validation->fails())
                return $this->jsonResponseWithError($validation->errors()->first());
    
            $this->user->update(['last_name' => $request->get('last_name')]);
            return response()->json(['result' => true]);
        }
    
        protected function changeEmail(Request $request)
        {
            $validation = Validator::make($request->all(), [
                'password' => 'required',
                'email' => 'required|email|between:5,100|unique:users'
            ]);
            
            if ($validation->fails())
                return $this->jsonResponseWithError($validation->errors()->first());
            
            if (!Hash::check($request->get('password'), $this->user->password))
                return $this->jsonResponseWithError(trans('errors.invalidPassword'));
            
            $this->user->update(['email' => $request->get('email')]);
            return response()->json(['result' => true]);
        }
    
        protected function changePassword(Request $request)
        {
            $validation = Validator::make($request->all(), [
                'password' => 'required',
                'new_password' => 'required|regex:/^(?=.*[A-Z]{1,})(?=.*[!@#$%^&*()_+-]{1,})(?=.*[0-9]{1,})(?=.*[a-z]{1,}).{8,}$/',
                'password_confirmation' => 'required|same:new_password'
            ]);
    
            if ($validation->fails())
                return $this->jsonResponseWithError($validation->errors()->first());
            
            if (!Hash::check($request->get('password'), $this->user->password))
                return $this->jsonResponseWithError(trans('errors.invalidCurrentPassword'));
            
            $this->user->update(['password' => Hash::make($request->get('new_password'))]);
            return response()->json(['result' => true]);
        }
        
        private function renameDir($oldLogin, $newLogin)
        {
            $this->manageDir($oldLogin);
            
            $oldDirName = public_path() . PATH_TO_PROFILE . $oldLogin;
            $newDirName = public_path() . PATH_TO_PROFILE . $newLogin;
            rename($oldDirName, $newDirName);
        }
    }
