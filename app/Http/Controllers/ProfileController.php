<?php

    namespace App\Http\Controllers;
    
    use App\User;
    use Illuminate\Http\Request;
    
    class ProfileController extends Controller {
        
        public function showAuthProfile() {
            return view('profiles.auth-profile', ['profile' => User::find(auth()->id())]);
        }
        
        public function showUserProfile() {
            dd('show user profile');
        }
        
        public function changeLogin(Request $request) {
            dd('change login');
        }
    
        public function changeFirstName(Request $request) {
            dd('change first name');
        }
    
        public function changeLastName(Request $request) {
            dd('change last name');
        }
    
        public function changeEmail(Request $request) {
            dd('change email');
        }
    
        public function changePassword(Request $request) {
            dd('change password');
        }
    }
