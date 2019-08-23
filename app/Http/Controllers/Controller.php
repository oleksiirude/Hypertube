<?php

    namespace App\Http\Controllers;
    
    use App\User;
    use Illuminate\Support\Str;
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Routing\Controller as BaseController;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    
    class Controller extends BaseController
    {
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        
        // manage creating necessary directories
        protected function manageDir($login) {
            if (!file_exists(public_path() . '/images/profiles'))
                mkdir(public_path() . '/images/profiles');
            if (!file_exists(public_path() . '/images/profiles/' . $login))
                mkdir(public_path() . '/images/profiles/' . $login);
        }
        
        // specify auth validation errors
        protected function specifyValidationErrors($validation) {
            $message = $validation->getMessageBag()->first();
            $div = key($validation->getMessageBag()->toArray());
            
            return [
                'result' => false,
                'error' => $message,
                'div' => $div
            ];
        }
    }