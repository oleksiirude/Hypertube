<template>
</template>

<script>
    export default {
        mounted () {
            document.getElementById('login').focus();
            document.getElementById('register-btn').addEventListener('click', this.ajaxRegister);
        },

        methods: {
            ajaxRegister: function (e) {
                e.preventDefault();

                let button = document.getElementById('register-btn');
                button.disabled = true;
                let inputs = document.getElementById('register-form').getElementsByTagName('input');

                const ajax = new XMLHttpRequest();
                ajax.open('POST', this.action, true);
                ajax.setRequestHeader('Content-Type', 'application/json');
                ajax.setRequestHeader('X-CSRF-TOKEN', this.csrf_token);
                ajax.send(JSON.stringify({
                    'login': inputs[0].value,
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

                let parent = document.getElementById(response['div'] + '-div');
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
                mainDiv.innerHTML = this.successful_registration;

                let internalDiv = document.createElement('div');
                internalDiv.className = 'text-center';

                let button = document.createElement('a');
                button.className = 'btn btn-primary';
                button.innerText = this.login_title;
                button.role = 'button';
                button.href = this.login_route;

                internalDiv.appendChild(button);
                mainDiv.appendChild(internalDiv);

                content.appendChild(mainDiv);
            }
        },

        name: "RegistrationComponent",
        props: [
            'action',
            'login_route',
            'csrf_token',

            // localization titles
            'login_title',
            'successful_registration'
        ]
    }
</script>