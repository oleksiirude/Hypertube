<?php

    namespace App\Http\Controllers;
    
    use Auth;
    use App\User;
    use Validator;
    use Illuminate\Http\Request;
    use Illuminate\Http\JsonResponse;
    use Intervention\Image\ImageManager;
    
    class ImageController extends Controller
    {
        private $user;
        
        public function __construct()
        {
            $this->middleware(function($request, $next)
            {
                $this->user = User::find(Auth::id());
                return $next($request);
            });
        }
    
        protected function changeAvatar(Request $request)
        {
            $result = $this->validateImage($request);
            if ($result instanceof JsonResponse)
                return $result;
    
            $login = $this->user->login;
            $this->manageDir($login);
            $this::manageAvatar($result, $login);
            $path = PATH_TO_PROFILE . $login . AVATAR;
            
            $this->user->where('uuid', auth()->id())->update([
                'avatar' => $path
            ]);
            
            return response()->json([
                'result' => true,
                'path' => $path
            ]);
        }
        
        protected function deleteAvatar()
        {
            if ($this->user->avatar === DEFAULT_AVATAR)
                return response()->json(['result' => false]);
            
            unlink(public_path() . '/' . $this->user->avatar);
            
            $this->user->update([
                'avatar' => DEFAULT_AVATAR
            ]);
            
            return response()->json(['result' => true]);
        }
        
        protected function validateImage(Request $request)
        {
            $validation = Validator::make($request->all(), [
                'avatar' => 'required|mimes:jpeg|max:5632|dimensions:min_width=200,min_height=200,max_width=5000,max_height=5000'
            ]);
            
            if ($validation->fails())
                $this->jsonResponseWithError($validation->errors()->first());
            
            return $request->file('avatar');
        }
        
        public static function manageAvatar($avatar, $login)
        {
            $absolutePath = public_path() . PATH_TO_PROFILE . $login . AVATAR;
            
            (new ImageManager())->make($avatar)
                ->orientate()
                ->fit(500, 500)
                ->save($absolutePath);
        }
    }
