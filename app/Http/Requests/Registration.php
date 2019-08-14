<?php

    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Contracts\Validation\Validator;
    use Illuminate\Http\Exceptions\HttpResponseException;
    
    class Registration extends FormRequest {
        
        public function authorize() {
            return true;
        }
        
        public function messages() {
            return [
                'unique' => 'This :attribute has already been taken',
                'regex' => ':Attribute is invalid',
                'string' => ':Attribute is invalid',
                'email' => ':Attribute is invalid',
                'required' => ':Attribute is required',
                'same' => 'Passwords do not match'
            ];
        }
    
        public function rules() {
            return [
                'username' => ['required', 'string', 'regex:/^[a-zA-Z]{3,20}$/', 'unique:users'],
                'first_name' => ['required', 'string', 'regex:/^[a-zA-Z]{2,20}$/'],
                'last_name' => ['required', 'string', 'regex:/^[a-zA-Z]{2,20}$/'],
                'email' => ['required', 'string', 'email', 'between:5,100', 'unique:users'],
                'password' => ['required', 'string', 'regex:/^(?=.*[A-Z]{1,})(?=.*[!@#$%^&*()_+-]{1,})(?=.*[0-9]{1,})(?=.*[a-z]{1,}).{8,}$/'],
                'password_confirmation' => ['required', 'string', 'same:password']
            ];
        }
    
        protected function failedValidation(Validator $validator) {
            throw new HttpResponseException(response()->json($this->parseErrors($validator->errors()), 200));
        }
        
        private function parseErrors($errors) {
            if ($errors->first('username'))
                return ['result' => false, 'error' => $errors->first('username'), 'id' => 'username-div'];
            else if ($errors->first('first_name'))
                return ['result' => false, 'error' => $errors->first('first_name'), 'id' => 'first_name-div'];
            else if ($errors->first('last_name'))
                return ['result' => false, 'error' => $errors->first('last_name'), 'id' => 'last_name-div'];
            else if ($errors->first('email'))
                return ['result' => false, 'error' => $errors->first('email'), 'id' => 'email'];
            else if ($errors->first('password'))
                return ['result' => false, 'error' => $errors->first('password'), 'id' => 'password'];
            else if ($errors->first('password_confirmation'))
                return ['result' => false, 'error' => $errors->first('password_confirmation'), 'id' => 'password_confirmation-div'];
        }
    }
