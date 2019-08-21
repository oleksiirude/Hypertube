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
                'login' => $request->get('login'),
                'password' => $request->get('password')],
                $request->get('remember'))) {
                
                App::setLocale($locale);
                session()->put('locale', $locale);
                return response()->json(['result' => true, 'locale' => App::getLocale()]);
            }
            
            return response()->json([
                'result' => false,
                'error' => trans('auth.failed'),
                'div' => 'password'
            ]);
        }
    
        protected function rules() {
            return [
                'login' => 'required|regex:/^[a-zA-Z]{3,20}[0-9]{0,10}?$/|unique:users',
                'password' => 'required|regex:/^(?=.*[A-Z]{1,})(?=.*[!@#$%^&*()_+-]{1,})(?=.*[0-9]{1,})(?=.*[a-z]{1,}).{8,}$/',
            ];
        }
    }
