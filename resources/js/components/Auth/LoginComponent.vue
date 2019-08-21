<template>
</template>

<script>
    export default {
        mounted () {
            document.getElementById('login').focus();

            document.getElementById('login-btn').addEventListener('click', this.ajaxLogin);

            // document.getElementById('42').addEventListener('click', this.disableLinks);
            // document.getElementById('github').addEventListener('click', this.disableLinks);
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

            // disableLinks: function () {
            //     let oauth = document.getElementById('oauth');
            //
            //     for (let i = 0; i < oauth.childElementCount; i++)
            //         oauth.children[i].href = 'javascript:void(0)';
            // }

        },

        name: "LoginComponent",
        props: [
            'action',
            'csrf_token',
            'main'
        ]
    }
</script>