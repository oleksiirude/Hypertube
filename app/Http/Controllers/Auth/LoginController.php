<?php

    namespace App\Http\Controllers\Auth;
    
    use Validator;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\LocaleController;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;

    class LoginController extends Controller
    {
        use AuthenticatesUsers;
        
        public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
    
        public function username()
        {
            return 'username';
        }
        
        public function login(Request $request)
        {
            $validation = Validator::make($request->all(), $this->rules());
            if ($validation->fails())
                return $this->specifyValidationErrors($validation);
            
            $remember_me = $request->get('remember') ? false : true;
            
            if (Auth::attempt([
                'login' => $request->get('login'),
                'password' => $request->get('password')],
                $remember_me)) {
                
                LocaleController::setLang();
                return response()->json(['result' => true, 'locale' => App::getLocale()]);
            }
            
            return response()->json([
                'result' => false,
                'error' => trans('errors.failed'),
                'div' => 'password'
            ]);
        }
    
        protected function rules()
        {
            return [
                'login' => 'required|regex:/^[a-z]{3,20}[0-9]{0,10}?$/i',
                'password' => 'required|regex:/^(?=.*[A-Z]{1,})(?=.*[!@#$%^&*()_+-]{1,})(?=.*[0-9]{1,})(?=.*[a-z]{1,}).{8,}$/',
            ];
        }
    }
