<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ register }}</div>

                    <div id="register-div" class="card-body">
                        <form id="register-form" :action="action">

                            <div id="username-div" class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">{{ username }}</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username" autofocus>
                                </div>
                            </div>

                            <div id="first_name-div" class="form-group row">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ first_name }}</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control" name="first_name">
                                </div>
                            </div>

                            <div id="last_name-div" class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ last_name }}</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control" name="last_name">
                                </div>
                            </div>

                            <div id="email-div" class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ email }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" name="email">
                                </div>
                            </div>

                            <div id="password-div" class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ password }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div id="password_confirmation-div" class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ password_confirmation }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button id="register" type="submit" class="btn btn-primary">
                                        {{ register }}
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
            document.getElementById('register').addEventListener('click', this.ajaxRegister);
        },

        methods: {
            ajaxRegister: function (e) {
                e.preventDefault();

                let button = document.getElementById('register');
                button.disabled = true;
                let inputs = document.getElementById('register-form').getElementsByTagName('input');

                const ajax = new XMLHttpRequest();
                ajax.open('POST', this.action, true);
                ajax.setRequestHeader('Content-Type', 'application/json');
                ajax.setRequestHeader('X-CSRF-TOKEN', this.csrf_token);
                ajax.send(JSON.stringify({
                    'username': inputs[0].value,
                    'first_name': inputs[1].value,
                    'last_name': inputs[2].value,
                    'email': inputs[3].value,
                    'password': inputs[4].value,
                    'password_confirmation': inputs[5].value
                }));

                ajax.onreadystatechange = () => {
                    if (ajax.status !== 200)
                        console.log('ajax response error with ' + ajax.status + ' status');
                    if (ajax.readyState === 4) {
                        let response = JSON.parse(ajax.responseText);
                        if (response['result'] === false) {
                            this.showErrorMessage(response);
                            button.disabled = false;
                        }
                        else
                            this.showSuccessMessage();
                    }
                }
            },

            showErrorMessage: function (response) {
                let error = document.getElementsByClassName('w-50 p-1 mb-2 ml-auto mr-auto bg-danger text-white text-center rounded');
                if (error.length)
                    error[0].remove();

                let parent = document.getElementById(response['id']);
                let child = document.createElement('div');
                child.innerHTML = response['error'];
                child.className = 'w-50 p-1 mb-2 ml-auto mr-auto bg-danger text-white text-center rounded';
                parent.parentNode.insertBefore(child, parent.nextSibling);
            },

            showSuccessMessage: function () {
                let content = document.getElementById('register-div');
                content.innerHTML = "";

                let mainDiv = document.createElement('div');
                mainDiv.className = 'text-center';
                mainDiv.innerHTML = 'You have been successfully registered!';

                let internalDiv = document.createElement('div');
                internalDiv.className = 'text-center';

                let button = document.createElement('a');
                button.className = 'btn btn-primary';
                button.innerText = 'Login';
                button.role = 'button';
                button.href = this.login;

                internalDiv.appendChild(button);
                mainDiv.appendChild(internalDiv);

                content.appendChild(mainDiv);
            }
        },

        name: "RegistrationComponent",
        props: [
            'action',
            'login',
            'csrf_token',
            // titles
            'register',
            'username',
            'first_name',
            'last_name',
            'email',
            'password',
            'password_confirmation'
        ]
    }
</script>

<style scoped>

</style>