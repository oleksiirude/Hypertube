<template>
    <div class="container login_div">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{trans('titles.setNewPasswordTitle') }}</div>

                    <div id="reset-password-div" class="card-body">
                        <form id="reset-password-form">

                            <div id="password-div" class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ trans('titles.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div id="password_confirmation-div" class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ trans('titles.passwordConfirmation') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button id="reset-password" type="submit" class="btn btn-primary" @click="ajaxResetPassword">
                                        {{ trans('titles.setNewPasswordAction') }}
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
            document.getElementById('password').focus();
        },

        methods: {
            ajaxResetPassword: function (e) {
                e.preventDefault();

                let button = document.getElementById('reset-password');
                button.disabled = true;
                let inputs = document.getElementById('reset-password-form').getElementsByTagName('input');

                const ajax = new XMLHttpRequest();
                ajax.open('POST', this.action, true);
                ajax.setRequestHeader('Content-Type', 'application/json');
                ajax.setRequestHeader('X-CSRF-TOKEN', this.csrf_token);
                ajax.send(JSON.stringify({
                    'token': this.token,
                    'email': this.email,
                    'password': inputs[0].value,
                    'password_confirmation': inputs[1].value,
                }));

                ajax.onreadystatechange = () => {
                    if (ajax.status !== 200)
                        console.log('ajax response error with ' + ajax.status + ' status');
                    if (ajax.readyState === 4) {
                        let response = JSON.parse(ajax.responseText);
                        if (response['result'] === false) {
                            this.showErrorMessage(response, button);
                        }
                        else
                            this.showSuccessMessage();
                    }
                }
            },

            showErrorMessage: function (response, button) {
                let error = document.getElementsByClassName('w-50 p-1 mb-2 ml-auto mr-auto bg-danger text-white text-center rounded');
                if (error.length)
                    error[0].remove();

                let parent = document.getElementById(response['div'] + '-div');
                let child = document.createElement('div');
                child.innerHTML = response['error'];
                child.className = 'w-50 p-1 mb-2 ml-auto mr-auto bg-danger text-white text-center rounded';
                parent.parentNode.insertBefore(child, document.getElementById(response['div'] + '-div').nextSibling);

                if (response['expired'] === true)
                    this.offerToMakeNewResetLink(response);
                else
                    button.disabled = false;
            },

            offerToMakeNewResetLink: function() {
                document.getElementById('reset-password').remove();

                let content = document.getElementById('reset-password-div');

                let internalDiv = document.createElement('div');
                internalDiv.className = 'text-center';

                let button = document.createElement('a');
                button.className = 'btn btn-primary';
                button.innerText = this.get_new_link;
                button.role = 'button';
                button.href = this.new_link;

                internalDiv.appendChild(button);
                content.appendChild(internalDiv);
            },

            showSuccessMessage: function () {
                document.getElementById('navbarSupportedContent').remove();

                let content = document.getElementById('reset-password-div');
                content.innerHTML = "";

                let mainDiv = document.createElement('div');
                mainDiv.className = 'text-center';
                mainDiv.innerHTML = this.successful_reset;

                let internalDiv = document.createElement('div');
                internalDiv.className = 'text-center';

                let button = document.createElement('a');
                button.className = 'btn btn-primary';
                button.innerText = this.continue;
                button.role = 'button';
                button.href = this.main;

                internalDiv.appendChild(button);
                mainDiv.appendChild(internalDiv);

                content.appendChild(mainDiv);
            }
        },

        name: "ResetPasswordComponent",
        props: [
            'action',
            'email',
            'token',
            'main',
            'new_link',
            'csrf_token',
            'successful_reset',
            'continue',
            'get_new_link'
        ]
    }
</script>