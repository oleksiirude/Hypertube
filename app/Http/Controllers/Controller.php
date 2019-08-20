<?php

    namespace App\Http\Controllers;
    
    use App\User;
    use Illuminate\Support\Str;
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Routing\Controller as BaseController;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    
    class Controller extends BaseController {
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        
        // specify auth validation errors
        public function specifyValidationErrors($validation) {
            $message = $validation->getMessageBag()->first();
            $div = key($validation->getMessageBag()->toArray());
            
            return [
                'result' => false,
                'error' => $message,
                'div' => $div
            ];
        }
        
        // get universally unique identifier for new User
        public function getNewUuidForUserTable() {
            while (true) {
                $uuid = Str::uuid()->toString();
                if (!User::find($uuid))
                    return $uuid;
            }
        }
    }