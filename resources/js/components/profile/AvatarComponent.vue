<template>
    <div id="vue_av_div" class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
        <div id="avatar_div">
            <img :src=mutableSrc :alt=alt class="poster_avatar" @click="choose_file('avatar_label')" id="avatar" title="click to download">
            <button class="destroy" @click="removeAvatar()" title="delete avatar"></button>
        </div>
        <span class="err_msg" @click="empty_err">{{ text }}</span>

        <!--        Change avatar-->
        <form method="POST" enctype="multipart/form-data" :action = action id="change_avatar_form">
            <input type="hidden" name="_token" :value = csrf>
            <input type="file" name="avatar" id="avatar_input" accept=".jpg, .jpeg" @change='upload' hidden>
            <label for="avatar_input" id="avatar_label" hidden>choose file</label>
        </form>

    </div>
</template>

<script>

    export default {
        props: [
            'src',
            'alt',
            'csrf',
            'action',
            'action_delete'
        ],
        data: function() {
            return {
                mutableSrc: this.src,
                i: 0,
                text: ''
            }
        },
        methods: {
            choose_file: function (label_name) {
                document.getElementById(label_name).click();
            },

            submit_form: function () {
                let self = this;
                const data = new FormData(document.getElementById('change_avatar_form'));
                axios.post(self.action, data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(function (response){
                        let res = response.data.result;
                        if (res === true)
                        {
                            self.mutableSrc = 'http://localhost:8080' + response.data.path + '?ver=' + self.i;
                            self.empty_err();
                            self.i++;
                        }
                        // console.log('RESP', response.data);
                    })
                    .catch((error) =>
                        console.log(error.response.data)
                    );
            },

            removeAvatar: function () {
                let self = this;
                axios.post(self.action_delete)
                    .then(function (response){
                        let res = response.data.result;
                        if (res === true)
                        {
                            self.mutableSrc = 'http://localhost:8080/images/service/defaultAvatar.png';
                            self.empty_err();
                        }
                        // console.log('RESP', response.data);
                    })
                    .catch((error) =>
                        console.log(error.response.data)
                    );
            },

            upload: function(){
                let file = document.getElementById("avatar_input").files[0];
                if (file) {
                    if ( file.type.match(/^image\//) ) {
                        if (file.size > 5000000)
                            this.text = '&#9755; ERROR: Too big image';
                        else
                            this.submit_form();
                    }
                    else {
                        this.text = "Invalid file type! Please select an image file.";
                    }
                }
                else {
                    this.text = 'No file(s) selected.';
                }
            },

            empty_err: function () {
                 this.text = '';
            }

        }
    }
</script>

<style scoped>
    #vue_av_div {
        display: inline-block;
        height: 100%;
        text-align: left;
        float: left;
    }
    #avatar_div {
        display: inline-block;

    }
    .poster_avatar {
        width: 100%;
        top: -50px;
        left: -50px;
        opacity: 1;
        position: relative;
        -webkit-filter: saturate(116%);
        border-radius: 100%;
        -webkit-mask-image: -webkit-gradient(linear, right top, left top, color-stop(1,rgba(0,0,0,1)), color-stop(0.5,rgba(0,0,0,1)), color-stop(0,rgba(0,0,0,0)));
        -webkit-mask-image: -webkit-gradient(linear, right top, left top, color-stop(1,rgba(0,0,0,1)), color-stop(0.5,rgba(0,0,0,1)), color-stop(0,rgba(0,0,0,0)));
        transition-property: opacity;
        transition-duration: 0.2s;
        transition-timing-function: ease-in;
    }
    #avatar:hover {
        cursor: pointer;
    }
    #avatar_div .destroy:after {
        display: inline-block;
        content: '×';
    }

    #avatar_div:hover .destroy {
        display: block;
    }
    #avatar_div .destroy {
        padding: 0px;
        display: none;
        position: absolute;
        top: 10px;
        margin-left: 10px;
        /*bottom: 0;*/
        width: 35px;
        height: 35px;
        font-size: 24px;
        color: white;
        background-color: transparent;
        border: none;
        opacity: 0.5;
        vertical-align: middle;
        line-height: normal;
        transition: color 0.2s ease-out;
    }
    #avatar_div .destroy:hover {
        opacity: 1;
        background-color: red;
    }

    .err_msg {
        position: absolute;
        color: red;
        top: 150px;
        font-size: 18px;
        margin-left: 20px;
    }
    .err_msg:hover {
        cursor: pointer;
        text-decoration: line-through;
    }

</style>