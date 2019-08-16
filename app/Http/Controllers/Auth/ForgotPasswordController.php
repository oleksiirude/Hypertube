<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Password;

    class ForgotPasswordController extends Controller{
        use SendsPasswordResetEmails;
        
        public function __construct() {
            $this->middleware('guest');
        }
        
        public function sendResetLinkEmail(Request $request) {
            $request->validate($this->rules());
            
            $response = $this->broker()->sendResetLink(
                $this->credentials($request)
            );
        
            return $response == Password::RESET_LINK_SENT
                ? $this->sendResetLinkResponse($request, $response)
                : $this->sendResetLinkFailedResponse($request, $response);
        }
    
        protected function rules() {
            return [
                'email' => 'required|email|between:5,100'
            ];
        }
        
        protected function sendResetLinkResponse(Request $request, $response) {
            return response()->json(['result' => true]);
        }
        
        protected function sendResetLinkFailedResponse(Request $request, $response) {
            return response()->json([
                'result' => false,
                'error' => trans('constant.nonexistent_email'),
                'id' => 'email-div'
            ]);
        }
    }
