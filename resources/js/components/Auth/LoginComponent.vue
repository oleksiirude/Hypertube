<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ login }}</div>

                    <div id="login-div" class="card-body">
                        <form id="login-form" :action="action">

                            <div id="username-div" class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">{{ username }}</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username" value="" autofocus>
                                </div>
                            </div>

                            <div id="password-div" class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ password }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                        <label class="form-check-label" for="remember">
                                            {{ remember_me }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button id="login" type="submit" class="btn btn-primary">
                                        {{ login }}
                                    </button>

                                    <a class="btn btn-link" :href="reset">
                                        {{ forgot_password }}
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
            document.getElementById('login').addEventListener('click', this.ajaxLogin);
        },

        methods: {
            ajaxLogin: function (e) {
                e.preventDefault();

                let button = document.getElementById('login');
                button.disabled = true;
                let inputs = document.getElementById('login-form').getElementsByTagName('input');

                const ajax = new XMLHttpRequest();
                ajax.open('POST', this.action, true);
                ajax.setRequestHeader('Content-Type', 'application/json');
                ajax.setRequestHeader('X-CSRF-TOKEN', this.csrf_token);
                ajax.send(JSON.stringify({
                    'username': inputs[0].value,
                    'password': inputs[1].value,
                    'remember': inputs[2].checked
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
                            window.location.href = this.main;
                    }
                }
            },

            showErrorMessage: function (response) {
                let error = document.getElementsByClassName('w-50 p-1 mb-2 ml-auto mr-auto bg-danger text-white text-center rounded');
                if (error.length)
                    error[0].remove();

                let parent =  document.getElementById(response['id']);
                let child = document.createElement('div');
                child.innerHTML = response['error'];
                child.className = 'w-50 p-1 mb-2 ml-auto mr-auto bg-danger text-white text-center rounded';
                parent.parentNode.insertBefore(child, parent.nextSibling);
            },

        },

        name: "LoginComponent",
        props: [
            'action',
            'reset',
            'main',
            'csrf_token',
            // titles
            'login',
            'username',
            'password',
            'remember_me',
            'forgot_password'
        ]
    }
</script>

<style scoped>

</style>