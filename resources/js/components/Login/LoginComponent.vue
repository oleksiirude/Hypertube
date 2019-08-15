<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div id="login-div" class="card-body">
                        <form id="login-form" :action="action">

                            <div id="username-div" class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username" value="" autofocus>
                                </div>
                            </div>

                            <div id="password-div" class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                        <label class="form-check-label" for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button id="login" type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    <a class="btn btn-link" :href="reset">
                                        Forgot Your Password?
                                    </a>
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
            let login = document.getElementById('login');
            if (login)
                login.addEventListener('click', this.ajaxLogin);
        },

        methods: {
            ajaxLogin: function (e) {
                e.preventDefault();

                let inputs = document.getElementById('login-form').getElementsByTagName('input');
                let validation = this.validateInputs(inputs);

                if (validation['result'] === true) {
                    const ajax = new XMLHttpRequest();
                    ajax.open('POST', this.action, true);
                    ajax.setRequestHeader('Content-Type', 'application/json');
                    ajax.send(JSON.stringify({
                        '_token': this.token,
                        'username': inputs[0].value,
                        'password': inputs[1].value,
                        'remember': inputs[2].checked
                    }));

                    ajax.onreadystatechange = () => {
                        if (ajax.status !== 200) {
                            console.log('ajax response error');
                        } else if (ajax.readyState === 4) {
                            let validation = JSON.parse(ajax.responseText);
                            if (!validation['result'])
                               this.handleNotValidRegistrationAttempt(validation);
                            else
                               window.location.href = this.main;
                        }
                    }
                } else
                    this.handleNotValidRegistrationAttempt(validation);
            },

            validateInputs: function (inputs) {
                if (inputs.length !== 3)
                    return {'result': false, 'error': 'Lack of inputs', 'id': 'login-div'};

                let result;
                if ((result = this.validateUsername(inputs[0])) !== true)
                    return result;
                if ((result = this.validatePassword(inputs[1])) !== true)
                    return result;
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
                let error = document.getElementsByClassName('w-50 p-1 mb-2 ml-auto mr-auto bg-danger text-white text-center rounded');
                if (error.length)
                    error[0].remove();

                let parent =  document.getElementById(validation['id']);
                let child = document.createElement('div');
                child.innerHTML = validation['error'];
                child.className = 'w-50 p-1 mb-2 ml-auto mr-auto bg-danger text-white text-center rounded';
                parent.parentNode.insertBefore(child, parent.nextSibling);
            },

        },

        name: "LoginComponent",
        props: [
            'action',
            'reset',
            'main',
            'token'
        ]
    }
</script>

<style scoped>

</style>