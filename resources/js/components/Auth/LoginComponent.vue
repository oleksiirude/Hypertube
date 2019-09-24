<template>
    <form id="login-form">

        <div id="login-div" class="form-group row">
            <label for="login" class="col-md-4 col-form-label text-md-right">{{ trans('titles.username') }}</label>

            <div class="col-md-6">
                <input id="login" type="text" class="form-control" name="login" value="" autocomplete="off">
            </div>
        </div>

        <div id="password-div" class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ trans('titles.password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" autocomplete="off">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" style="cursor: pointer" autocomplete="off">

                    <label class="form-check-label" for="remember">
                        {{ trans('titles.doNotRememberMe') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button id="login-btn" type="submit" class="btn btn-primary" @click="ajaxLogin">
                    {{ trans('titles.signIn') }}
                </button>

                <a class="btn btn-link" :href="forget_pass">
                    {{ trans('titles.forgotPassword') }}
                </a>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        mounted () {
            document.getElementById('login').focus();
        },

        methods: {
            ajaxLogin: function (e) {
                e.preventDefault();

                let button = document.getElementById('login-btn');
                button.disabled = true;
                let inputs = document.getElementById('login-form').getElementsByTagName('input');

                const ajax = new XMLHttpRequest();
                ajax.open('POST', this.action, true);
                ajax.setRequestHeader('Content-Type', 'application/json');
                ajax.setRequestHeader('X-CSRF-TOKEN', this.csrf_token);
                ajax.send(JSON.stringify({
                    'login': inputs[0].value,
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

                let parent =  document.getElementById(response['div'] + '-div');
                let child = document.createElement('div');
                child.innerHTML = response['error'];
                child.className = 'w-50 p-1 mb-2 ml-auto mr-auto bg-danger text-white text-center rounded';
                parent.parentNode.insertBefore(child, parent.nextSibling);
            },
        },

        name: "LoginComponent",
        props: [
            'action',
            'csrf_token',
            'main',
            'forget_pass'
        ]
    }
</script>