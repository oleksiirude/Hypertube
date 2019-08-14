<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>

                    <div id="register-div" class="card-body">
                        <form id="register-form" :action="action">

                            <div id="username-div" class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username"autofocus>
                                </div>
                            </div>

                            <div id="first_name-div" class="form-group row">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control" name="first_name">
                                </div>
                            </div>

                            <div id="last_name-div" class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control" name="last_name">
                                </div>
                            </div>

                            <div id="email-div" class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" name="email">
                                </div>
                            </div>

                            <div id="password-div" class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div id="password_confirmation-div" class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button id="register" type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted () {
            let register =  document.getElementById('register');
            if (register)
                register.addEventListener('click', this.ajaxRegister);
        },

        methods: {
            ajaxRegister: function (e) {
                e.preventDefault();

                let inputs = document.getElementById('register-form').getElementsByTagName('input');
                let validation = this.validateInputs(inputs);

                if (validation['result'] === true) {
                    const ajax = new XMLHttpRequest();
                    ajax.open('POST', this.action, true);
                    ajax.setRequestHeader('Content-Type', 'application/json');
                    ajax.send(JSON.stringify({
                        '_token': this.token,
                        'username': inputs[0].value,
                        'first_name': inputs[1].value,
                        'last_name': inputs[2].value,
                        'email': inputs[3].value,
                        'password': inputs[4].value,
                        'password_confirmation': inputs[5].value,
                    }));

                    ajax.onreadystatechange = () => {
                        if (ajax.status !== 200) {
                            console.log('ajax response error');
                        } else if (ajax.readyState === 4) {
                            let validation = JSON.parse(ajax.responseText);
                            console.log(validation);
                            if (!validation['result'])
                                this.handleNotValidRegistrationAttempt(validation);
                            else
                                window.location.href = this.login;
                        }
                    }
                } else
                    this.handleNotValidRegistrationAttempt(validation);
            },

            validateInputs: function (inputs) {
                if (inputs.length !== 6)
                    return {'result': false, 'error': 'Lack of inputs', 'id': 'register-div'};

                let result;
                if ((result = this.validateUsername(inputs[0])) !== true)
                    return result;
                if ((result = this.validateFirstName(inputs[1])) !== true)
                    return result;
                if ((result = this.validateLastName(inputs[2])) !== true)
                    return result;
                if ((result = this.validateEmail(inputs[3])) !== true)
                    return result;
                if ((result = this.validatePassword(inputs[4])) !== true)
                    return result;
                if (inputs[4].value !== inputs[5].value || inputs[5].id !== 'password-confirm')
                    return {'result': false, 'error': 'Passwords do not match','id': 'password_confirmation-div'};
                return {'result': true};
            },

            validateUsername: function(input) {
                if (/^username$/.test(input.id)) {
                    if (!input.value.length)
                        return {'result': false, 'error': 'Username is required', 'id': 'username-div'};
                    if (/^[a-zA-Z]{3,20}$/.test(input.value))
                        return true;
                }
                return {'result': false, 'error': 'Invalid username', 'id': 'username-div'};
            },

            validateFirstName: function(input) {
                if (/^first_name$/.test(input.id)) {
                    if (!input.value.length)
                        return {'result': false, 'error': 'First name is required', 'id': 'first_name-div'};
                    if (/^[a-zA-Z]{2,20}$/.test(input.value))
                        return true;
                }
                return {'result': false, 'error': 'Invalid first name', 'id': 'first_name-div'};
            },

            validateLastName: function(input) {
                if (/^last_name$/.test(input.id)) {
                    if (!input.value.length)
                        return {'result': false, 'error': 'Last name is required', 'id': 'last_name-div'};
                    if (/^[a-zA-Z]{2,20}$/.test(input.value))
                        return true;
                }
                return {'result': false, 'error': 'Invalid last name', 'id': 'last_name-div'};
            },

            validateEmail: function(input) {
                if (/^email$/.test(input.id)) {
                    if (!input.value.length)
                        return {'result': false, 'error': 'Email is required', 'id': 'email-div'};
                    if (/^[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/.test(input.value))
                        return true;
                }
                return {'result': false, 'error': 'Invalid email', 'id': 'email-div'};
            },

            validatePassword: function(input) {
                if (/^password$/.test(input.id)) {
                    if (!input.value.length)
                        return {'result': false, 'error': 'Password is required', 'id': 'password-div'};
                    if (/^(?=.*[A-Z]{1,})(?=.*[!@#$%^&*()_+-]{1,})(?=.*[0-9]{1,})(?=.*[a-z]{1,}).{8,}$/.test(input.value))
                        return true;
                }
                return {'result': false, 'error': 'Invalid password', 'id': 'password-div'};
            },

            handleNotValidRegistrationAttempt: function (validation) {
                let error = document.getElementsByClassName('text-danger text-center');
                if (error.length)
                    error[0].remove();

                let parent =  document.getElementById(validation['id']);
                let child = document.createElement('div');
                child.innerHTML = validation['error'];
                child.className = 'text-danger text-center';
                parent.parentNode.insertBefore(child, parent.nextSibling);
            },

        },

        name: "RegistrationComponent",
        props: [
            'action',
            'login',
            'token'
        ]
    }
</script>

<style scoped>

</style>