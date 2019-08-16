<?php

    namespace App\Http\Controllers\Auth;
    
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use App\Http\Controllers\Controller;
    use Illuminate\Auth\Events\PasswordReset;
    use Illuminate\Support\Facades\Password;
    use Illuminate\Foundation\Auth\ResetsPasswords;
    
    class ResetPasswordController extends Controller {
        use ResetsPasswords;
        
        public function __construct() {
            $this->middleware('guest');
        }
        
        public function reset(Request $request) {
            $request->validate($this->rules());
            
            $response = $this->broker()->reset(
                $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
            );
            
            return $response == Password::PASSWORD_RESET
                ? $this->sendResetResponse($request, $response)
                : $this->sendResetFailedResponse($request, $response);
        }
        
        protected function rules() {
            return [
                'email' => 'required|email|between:5,100',
                'password' => 'required|regex:/^(?=.*[A-Z]{1,})(?=.*[!@#$%^&*()_+-]{1,})(?=.*[0-9]{1,})(?=.*[a-z]{1,}).{8,}$/',
                'password_confirmation' => 'required|same:password'
            ];
        }
        
        protected function resetPassword($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        
            event(new PasswordReset($user));
            $this->guard()->login($user);
        }
        
        protected function sendResetResponse(Request $request, $response) {
            return response()->json(['result' => true]);
        }
        
        protected function sendResetFailedResponse(Request $request, $response) {
            return response()->json([
                'result' => false,
                'target' => 'expired',
                'error' => 'It seems your link is expired!',
                'id' => 'password_confirmation-div'
            ]);
        }
    }
