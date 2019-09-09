<template>
    <div>
        <p class="titles">{{ title }}: </p>
        <p class="profiledata" @mouseover="upHere = true" @mouseleave="upHere = false" @click="showData">{{ mutableValue }}</p>
        <img :src = "edit" class="edit_img" v-show="upHere">
        <form method="POST" :action="action" :id="name" v-show="!isHidden">
            <label :for="'new_' + name" class="titles">&#10148;&#10148;&#10148; {{ trans('titles.newEmail') }}: </label>
            <input type="text" name="email" class="profiledata" autocomplete="off" :id="'new_' + name">
            <br>
            <label for="password_email" class="titles">&#10148;&#10148;&#10148; {{ trans('titles.password') }}: </label>
            <input :type="type" name="password" class="profiledata" autocomplete="off" id="password_email">
            <img :src = "mutableEye" class="eye_img" @click="show_hide">
        </form>
        <div v-show="!isHidden">
            <button type="submit" v-show="!isHidden" id="" class="btn edit_submit" @click="submit">{{ title_save | capitalize }}</button>
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
            'titles',
            'eye_show',
            'eye_hide'
        ],
        data: function() {
            return {
                error: '',
                mutableValue: this.value,
                isHidden: true,
                upHere: false,
                mutableEye: this.eye_show,
                type: 'password'
            }
        },
        methods: {
            show_hide: function(){
                let img1 = this.eye_show,
                    img2 = this.eye_hide;
                let imgElement = this.mutableEye;
                if (imgElement === img1) {
                    this.mutableEye = img2;
                    this.type = 'text';
                } else {
                    this.mutableEye = img1;
                    this.type = 'password';
                }

            },
            showData: function(){
                this.isHidden = !this.isHidden;
                this.empty_err();
            },
            parseData(data) {
                this.object= JSON.parse(data);
            },
            empty_err: function () {
                this.error = '';
            },
            cancel: function () {
                this.isHidden = true;
                document.getElementById('new_' + this.name).value = '';
                document.getElementById('password_email').value = '';
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
                            self.mutableValue = document.getElementById('new_' + self.name).value;
                            self.isHidden = true;
                            self.empty_err();
                        }
                        else {
                            self.error = response.data.error;
                        }
                        // console.log('RESP', response.data);
                    })
                    .catch((error) =>
                        console.log(error.response.data)
                    );
            },
        }
    }
</script>

<style scoped>
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