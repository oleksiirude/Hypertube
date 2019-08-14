<?php

    namespace App\Http\Controllers\Auth;
    
    use App\User;
    use App\Http\Requests\Registration;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Foundation\Auth\RegistersUsers;
    
    class RegisterController extends Controller {
        
        use RegistersUsers;
        
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct() {
            $this->middleware('guest');
        }
    
        public function register(Registration $request) {
            $this->create($request->all());
            
            return response()->json(['result' => true]);
        }
    
        /**
         * Create a new user instance after a valid registration.
         *
         * @param  array  $data
         * @return \App\User
         */
        protected function create(array $data) {
            return User::create([
                'id' => $this->getNewUuidForUserTable(),
                'username' => $data['username'],
                'first_name' => ucfirst($data['first_name']),
                'last_name' => ucfirst($data['last_name']),
                'email' => strtolower($data['email']),
                'password' => Hash::make($data['password']),
            ]);
        }
    }
