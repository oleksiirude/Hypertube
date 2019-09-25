<?php

    namespace App\Http\Controllers;
    
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Routing\Controller as BaseController;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    
    class Controller extends BaseController
    {
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        
        // manage creating necessary directories
        protected function manageDir($login)
        {
            if (!file_exists(public_path() . PATH_TO_PROFILE))
                mkdir(public_path() . PATH_TO_PROFILE);
            if (!file_exists(public_path() . PATH_TO_PROFILE . $login))
                mkdir(public_path() . PATH_TO_PROFILE . $login);
        }
        
        // specify auth validation errors
        protected function specifyValidationErrors($validation)
        {
            $message = $validation->errors()->first();
            $div = key($validation->errors()->toArray());
            
            return [
                'result' => false,
                'error' => $message,
                'div' => $div
            ];
        }
    
        // prepare json response with error
        protected function jsonResponseWithError($error = null)
        {
            return response()->json([
                'result' => false,
                'error' => $error
            ]);
        }
    
        // prepare json response with success
        protected function jsonResponseWithSuccess($data = null)
        {
            return response()->json([
                'result' => true,
                'data' => $data
            ]);
        }
    }