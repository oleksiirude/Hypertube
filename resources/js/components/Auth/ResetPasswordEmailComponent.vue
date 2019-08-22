<template>
</template>

<script>
    export default {
        mounted () {
            document.getElementById('email').focus();
            document.getElementById('send-email').addEventListener('click', this.ajaxSendResetEmailLink);
        },

        methods: {
            ajaxSendResetEmailLink: function (e) {
                e.preventDefault();

                let button = document.getElementById('send-email');
                //button.disabled = true;
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

            // localization titles
            'successful_link'
        ]
    }
</script>