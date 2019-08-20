<?php

    namespace App\Http\Controllers\Auth;

    use Validator;
    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Auth;

    class LoginController extends Controller {
    
        use AuthenticatesUsers;
        
        public function __construct() {
            $this->middleware('guest')->except('logout');
        }
    
        public function username() {
            return 'username';
        }
        
        public function login(Request $request) {
            $validation = Validator::make($request->all(), $this->rules());
            if ($validation->fails())
                return $this->specifyValidationErrors($validation);
            
            $locale = session()->get('locale');
            
            if (Auth::attempt([
                'username' => $request->get('username'),
                'password' => $request->get('password')],
                $request->get('remember'))) {
                
                App::setLocale($locale);
                session()->put('locale', $locale);
                return response()->json(['result' => true, 'locale' => App::getLocale()]);
            }
            
            return response()->json([
                'result' => false,
                'error' => trans('auth.failed'),
                'id' => 'password-div'
            ]);
        }
    
        protected function rules() {
            return [
                'username' => 'required|regex:/^[a-zA-Z]{3,20}$/',
                'password' => 'required|regex:/^(?=.*[A-Z]{1,})(?=.*[!@#$%^&*()_+-]{1,})(?=.*[0-9]{1,})(?=.*[a-z]{1,}).{8,}$/',
            ];
        }
    }
