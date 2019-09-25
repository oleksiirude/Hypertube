<template>
    <div>
        <label :for="name" class="titles">{{ title }}: </label>
        <input :name="name" class="profiledata"
               :id="name"
               @keydown="isHidden = false"
               :value="mutableValue" placeholder="" autocomplete="off"
               @mouseover="upHere = true">
        <button type="submit" v-show="!isHidden" id="" class="btn edit_submit" @click="submit">{{ title_save | capitalize }}</button>
        <button v-show="!isHidden" class="btn edit_submit cancel" @click="cancel">{{ title_cancel | capitalize}}</button>
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
            'title_cancel'
        ],
        data: function() {
            return {
                error: '',
                mutableValue: this.value,
                isHidden: true,
                upHere: false
            }
        },
        methods: {
            empty_err: function () {
                this.error = '';
            },
            submit: function () {
                let self = this;
                const data = new FormData();
                let info = document.getElementById(this.name).value;
                data.append(this.name, info);
                axios.post(self.action, data)
                    .then(function (response){
                        let res = response.data.result;
                        if (res === true)
                        {
                            self.mutableValue = document.getElementById(self.name).value;
                            self.isHidden = true;
                            self.empty_err();
                        }
                        else {
                            self.error = response.data.error;
                        }
                    })
                    .catch((error) => {
                        // console.log(error.response.data)
                        }
                    );
            }, 
            cancel: function () {
                this.isHidden = true;
                // document.getElementById(this.name).value = this.mutableValue;
                this.empty_err();
            }
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
        margin-right: 10px;
        position: relative;
        color: gray;
        height: 100%;
        cursor: pointer !important;
    }
    .edit_submit:hover {
        -webkit-animation: neon2 1.5s ease-in-out infinite alternate;
        text-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
        color: white;
    }
    .edit_submit:focus {
        outline: none;
        box-shadow: none
    }
    .err_msg {
        display: inline-block;
        color: red;
        font-size: 14.4px;
        vertical-align: middle;
    }
    .err_msg:hover {
        cursor: pointer;
        text-decoration: line-through;
    }
    .edit_img {
        width: 20px;
        opacity: 0.5;
    }

</style>