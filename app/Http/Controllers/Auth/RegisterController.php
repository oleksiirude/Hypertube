<?php

    namespace App\Http\Controllers\Auth;
    
    use App\User;
    use Validator;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\RegistersUsers;
    
    class RegisterController extends Controller
    {
        
        use RegistersUsers;
        
        public function __construct()
        {
            $this->middleware('guest');
        }
    
        public function register(Request $request)
        {
            $validation = Validator::make($request->all(), $this->rules());
            if ($validation->fails())
                return $this->specifyValidationErrors($validation);
            
            $this->create($request->all());
            return response()->json(['result' => true]);
        }
    
        protected function rules()
        {
            return [
                'login' => 'required|regex:/^[a-z]{3,20}[0-9]{0,10}?$/i|unique:users',
                'first_name' => 'required|regex:/^[a-zа-яёїі]{2,20}$/iu',
                'last_name' => 'required|regex:/^[a-zа-яёїі]{2,20}$/iu',
                'email' => 'required|email|between:5,100|unique:users',
                'password' => 'required|regex:/^(?=.*[A-Z]{1,})(?=.*[!@#$%^&*()_+-]{1,})(?=.*[0-9]{1,})(?=.*[a-z]{1,}).{8,}$/',
                'password_confirmation' => 'required|same:password'
            ];
        }
        
        protected function create(array $data)
        {
            return User::create([
                'uuid' => User::getNewUuidForUserTable(),
                'login' => $data['login'],
                'first_name' => ucfirst($data['first_name']),
                'last_name' => ucfirst($data['last_name']),
                'email' => strtolower($data['email']),
                'password' => Hash::make($data['password']),
            ]);
        }
    }
