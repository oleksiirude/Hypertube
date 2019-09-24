<template>
    <div>
        <p class="titles" @mouseover="upHere = true" @mouseleave="upHere = false" @click="showData">{{ trans('titles.editPassword') }}? </p>
        <img :src = "edit" class="edit_img" v-show="upHere">
        <form method="POST" :action="action" :id="name" v-show="!isHidden">
            <label :for="'current_' + name" class="titles">&#10148;&#10148;&#10148; {{ trans('titles.currentPassword') }}: </label>
            <input :type="typeCurrent" name="password" class="profiledata" :id="'current_' + name">
            <img :src = "mutableEyeCurrent" class="eye_img" @click="show_hide"><br>
            <label :for="'new_' + name" class="titles">&#10148;&#10148;&#10148; {{ trans('titles.newPassword') }}: </label>
            <input :type="typeNew" name="new_password" class="profiledata" :id="'new_' + name">
            <img :src = "mutableEyeNew" class="eye_img" @click="show_hide"><br>
            <label :for="'confirm_' + name" class="titles">&#10148;&#10148;&#10148; {{ trans('titles.passwordConfirmation') }}: </label>
            <input :type="typeConfirm" name="password_confirmation" class="profiledata" :id="'confirm_' + name">
            <img :src = "mutableEyeConfirm" class="eye_img" @click="show_hide">
        </form>
        <div v-show="!isHidden">
            <button type="submit" v-show="!isHidden" id="" class="btn edit_submit" @click="submit">{{ title_save | capitalize}}</button>
            <button v-show="!isHidden" class="btn edit_submit cancel" @click="cancel">{{ title_cancel | capitalize}}</button>
        </div>
        <span class="err_msg" @click="empty_err">{{ error }}</span>
    </div>
</template>

<script>
    export default {
        props: [
            'name',
            'title',
            'value',
            'action',
            'edit',
            'title_save',
            'title_cancel',
            'eye_show',
            'eye_hide'
        ],
        data: function() {
            return {
                error: '',
                isHidden: true,
                upHere: false,
                mutableEyeCurrent: this.eye_show,
                mutableEyeNew: this.eye_show,
                mutableEyeConfirm: this.eye_show,
                typeCurrent: 'password',
                typeNew: 'password',
                typeConfirm: 'password'
            }
        },
        methods: {
            show_hide: function(e){
                // console.log(e);
                e.preventDefault();
                let path = e.path || (e.composedPath && e.composedPath()) || composedPath(e.target);
                let img1 = this.eye_show,
                    img2 = this.eye_hide;
                let imgElement = path[0].src;
                let type = path[0].previousElementSibling.type;
                if (imgElement === img1) {
                    path[0].src = img2;
                    path[0].previousElementSibling.type = 'text';
                } else {
                    path[0].src = img1;
                    path[0].previousElementSibling.type = 'password';
                }
            },
            showData: function(){
                this.isHidden = !this.isHidden;
                this.empty_err();
            },
            empty_err: function () {
                this.error = '';
            },
            cancel: function () {
                this.isHidden = true;
                document.getElementById('current_' + this.name).value = '';
                document.getElementById('new_' + this.name).value = '';
                document.getElementById('confirm_' + this.name).value = '';
                this.empty_err();
            },
            submit: function () {
                let self = this;
                let data = new FormData(document.getElementById(this.name));
                // data.append(this.name, info);
                axios.post(self.action, data)
                    .then(function (response){
                        let res = response.data.result;
                        if (res === true)
                        {
                            // self.mutableValue = document.getElementById('new_' + self.name).value;
                            self.isHidden = true;
                            self.empty_err();
                        }
                        else {
                            self.error = response.data.error;
                        }
                        // console.log('RESP', response.data);
                    })
                    .catch((error) => {
                            // console.log(error.response.data);
                        }
                    );
            },
        }
    }
</script>

<style scoped>
    .titles {
        cursor: pointer;
    }
    .profiledata {
        display: inline-block;
        border: none;
        background-color: transparent;
        color: white;
    }
    :focus {
        outline: black auto 2px;
    }
    .edit_submit {
        margin-top: 10px;
        margin-right: 10px;
        position: relative;
        background: rgba(255,255,255,0.3);
        color: #fff;
        height: 100%;
        border-radius: 4px;
        border: 1px rgba(255,255,255, 0.91) solid;
        cursor: pointer !important;
        /*box-shadow: 2px 2px 2px rgba(0, 0, 0, 1);*/
    }
    .edit_submit:hover {
        -webkit-animation: neon2 1.5s ease-in-out infinite alternate;
        text-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
    }
    .err_msg {
        display: inline-block;
        /*width: 100%;*/
        color: red;
        font-size: 14.4px;
        vertical-align: middle;
    }
    .err_msg:hover {
        cursor: pointer;
        text-decoration: line-through;
    }
    .edit_img {
        /*display: none;*/
        width: 20px;
        opacity: 0.5;
    }
    .eye_img {
        width: 20px;
        opacity: 0.5;
        cursor: pointer;
    }
    .eye_img:hover {
        opacity: 1;
    }
</style>