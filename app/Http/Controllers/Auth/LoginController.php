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
            $request->validate($this->rules());
            
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
    
        protected function rules() {
            return [
                'username' => 'required|regex:/^[a-zA-Z]{3,20}$/',
                'password' => 'required|regex:/^(?=.*[A-Z]{1,})(?=.*[!@#$%^&*()_+-]{1,})(?=.*[0-9]{1,})(?=.*[a-z]{1,}).{8,}$/',
            ];
        }
    }
