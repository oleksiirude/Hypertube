<?php

    namespace App\Http\Controllers\Auth;

    use App\User;
    use Validator;
    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Password;

    class ForgotPasswordController extends Controller
    {
        use SendsPasswordResetEmails;
        
        public function __construct()
        {
            $this->middleware('guest');
        }
        
        public function sendResetLinkEmail(Request $request)
        {
            $validation = Validator::make($request->all(), [
                'email' => 'required|email|between:5,100'
            ]);
            if ($validation->fails())
                return $this->specifyValidationErrors($validation);

            if (!$this->checkIfAuthByProvider($request->get('email')))
                return $this->sendResetLinkFailedResponse();
            
            $response = $this->broker()->sendResetLink(
                $this->credentials($request)
            );
            
            return $response == Password::RESET_LINK_SENT
                ? $this->sendResetLinkResponse()
                : $this->sendResetLinkFailedResponse();
        }
    
        protected function checkIfAuthByProvider($email)
        {
            if (User::where([
                'email' => $email,
                'auth_provider' => null
            ])->first())
                return true;
            return false;
        }
        
        protected function sendResetLinkResponse()
        {
            return response()->json(['result' => true]);
        }
        
        protected function sendResetLinkFailedResponse()
        {
            return response()->json([
                'result' => false,
                'error' => trans('errors.nonexistentEmail'),
                'div' => 'email'
            ]);
        }
    }
