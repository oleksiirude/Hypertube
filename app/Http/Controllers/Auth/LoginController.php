<?php

    namespace App\Http\Controllers\Auth;
    
    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Http\Request;
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
            if (($result = $this->validateNotEmpty($request->all())) !== true)
                return response()->json($result);
            
            if (Auth::attempt([
                'username' => $request->get('username'),
                'password' => $request->get('password')],
                $request->get('remember')))
                return response()->json(['result' => true]);
            
            return response()->json([
                'result' => false,
                'error' => 'Invalid username or password',
                'id' => 'password-div'
            ]);
        }
        
        protected function validateNotEmpty($data) {
            if (!isset($data['username']) || empty($data['username']))
                return [
                    'result' => false,
                    'error' => 'Username is required',
                    'id' => 'username-div'
                ];
            if (!isset($data['password']) || empty($data['password']))
                return [
                    'result' => false,
                    'error' => 'Password is required',
                    'id' => 'password-div'
                ];
            if (!isset($data['remember']) || !is_bool($data['remember']))
                return [
                    'result' => false,
                    'error' => 'Lack of inputs',
                    'id' => 'login-div'
                ];
            
            return true;
        }
    }
