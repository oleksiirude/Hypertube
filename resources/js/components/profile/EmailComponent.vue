<template>
    <div>
        <p class="titles">{{ title }}: </p>
        <p class="profiledata" @mouseover="upHere = true" @mouseleave="upHere = false" @click="isHidden = !isHidden">{{ mutableValue }}</p>
        <img :src = "edit" class="edit_img" v-show="upHere">
        <form method="POST" :action="action" :id="name" v-show="!isHidden">
            <label :for="'new_' + name" class="titles">&#10148;&#10148;&#10148; New E-mail: </label>
            <input type="text" name="email" class="profiledata" autocomplete="off" :id="'new_' + name" :value="newemail"><br>
            <label for="password" class="titles">&#10148;&#10148;&#10148;{{ trans('titles.password') }}: </label>
            <input type="password" name="password" class="profiledata" autocomplete="off" :value="password" id="password">
        </form>
        <div>
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
            'titles'
        ],
        data: function() {
            return {
                error: '',
                mutableValue: this.value,
                isHidden: true,
                upHere: false,
                newemail: '',
                password: ''
            }
        },
        mounted(){
            console.log('dfdf', this.titles);
        },
        methods: {
            parseData(data) {
                this.object= JSON.parse(data);
            },
            empty_err: function () {
                this.error = '';
            },
            cancel: function () {
                this.isHidden = true;
                // document.getElementById(this.name).value = this.mutableValue;
                this.empty_err();
            },
            submit: function () {
                let self = this;
                const data = new FormData(document.getElementById(this.name));
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
                        console.log('RESP', response.data);
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
</style>