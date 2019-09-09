<template>
    <div class="container login_div">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ trans('titles.resetPassword') }}</div>

                    <div id="reset-password-div" class="card-body">
                        <form>
                            <div id="email-div" class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ trans('titles.email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="text" autofocus>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button id="send-email" type="submit" class="btn btn-primary" @click="ajaxSendResetEmailLink">
                                        {{ trans('titles.sendLink') }}
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
            document.getElementById('email').focus();
        },

        methods: {
            ajaxSendResetEmailLink: function (e) {
                e.preventDefault();

                let button = document.getElementById('send-email');
                button.disabled = true;
                let input = document.getElementById('email');

                const ajax = new XMLHttpRequest();
                ajax.open('POST', this.action, true);
                ajax.setRequestHeader('Content-Type', 'application/json');
                ajax.setRequestHeader('X-CSRF-TOKEN', this.csrf_token);
                ajax.send(JSON.stringify({
                    'email': input.value,
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
                            this.showSuccessMessage(input.value);
                    }
                }
            },

            showErrorMessage: function (response) {
                let error = document.getElementsByClassName('w-50 p-1 mb-2 ml-auto mr-auto bg-danger text-white text-center rounded');
                if (error.length)
                    error[0].remove();

                let parent = document.getElementById(response['div'] + '-div');
                let child = document.createElement('div');
                child.innerHTML = response['error'];
                child.className = 'w-50 p-1 mb-2 ml-auto mr-auto bg-danger text-white text-center rounded';
                parent.parentNode.insertBefore(child, parent.nextSibling);
            },

            showSuccessMessage: function (email) {
                let content = document.getElementById('reset-password-div');
                content.innerHTML = "";

                let mainDiv = document.createElement('div');
                mainDiv.className = 'text-center';
                mainDiv.innerHTML = this.successful_link + email;

                content.appendChild(mainDiv);
            }

        },

        name: "ResetPasswordEmailComponent",
        props: [
            'action',
            'csrf_token',
            'successful_link'
        ]
    }
</script>