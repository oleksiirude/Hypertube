<template>
    <div>
        <p class="titles"> {{ title }}: </p>
        <textarea type="text" :name="name" :placeholder="no_bio + '. '+ placeholder"
                  class="profiledata" contenteditable="true"
                  id="bio"
                  maxlength="500"
                  spellcheck="false"
                  @mouseover="upHere = true" @mouseleave="upHere = false"
                  @keyup="check_onkeyup($event.srcElement)"
        >{{ mutableBio }}</textarea>
        <img :src = "edit" class="edit_img" v-show="upHere">
        <span class="err_msg" @click="empty_err">{{ error }}</span>
        <button type="submit" v-show="!isHidden" id="bio_btn" class="btn edit_submit" @click="submit">{{ title_save | capitalize}}</button>
        <button type="submit" v-show="!isHidden" class="btn edit_submit cancel" @click="cancel">{{ title_cancel | capitalize }}</button>
    </div>
</template>

<script>
    export default {
        props: [
            'bio',
            'no_bio',
            'csrf',
            'action',
            'name',
            'title',
            'placeholder',
            'edit',
            'title_save',
            'title_cancel'
        ],
        data: function() {
            return {
                isHidden: true,
                mutableBio: this.bio.trim(),
                error: '',
                upHere: false
            }
        },
        methods: {
            auto_grow: function(element) {
                // console.log('el', element)
                element.style.height = "5px";
                element.style.height = (element.scrollHeight)+"px";
            },
            check_onkeyup: function (element) {
                this.auto_grow(element);
                this.isHidden = false;
            },
            empty_err: function () {
                this.error = '';
            },

            cancel: function () {
                this.isHidden = true;
                document.getElementById('bio').value = this.mutableBio;
                this.empty_err();
            },
            submit: function () {
                let self = this;
                const data = new FormData();
                let info = document.getElementById('bio').value.trim();
                data.append('info', info);
                axios.post(self.action, data, {
                    headers: {
                        'Content-Type': 'text/plain'
                    }
                })
                    .then(function (response) {
                        let res = response.data.result;
                        if (res === true)
                        {
                            if (document.getElementById('bio').value.trim() == '')
                            {
                                self.mutableBio = '';
                                document.getElementById('bio').value = '';
                            }
                            else {
                                let el = document.getElementById('bio');
                                self.mutableBio = el.value.trim();
                                el.value = self.mutableBio;
                                self.auto_grow(el);
                            }
                            self.isHidden = true;
                            self.empty_err();
                        }
                        else {
                            self.error = response.data.error;
                        }
                    }).catch((error) => {

                    }
                );
            },
        },
        mounted(){
            let element = document.getElementById('bio');
            this.auto_grow(element);
        },
    }
</script>

<style scoped>
    #bio {
        background-color: transparent;
        color: white;
        word-wrap: break-word;
        width: calc(100% - 120px);
        max-height: 100%;
        max-width: 500px;
        vertical-align: top;
        padding: 0px;
        padding-left: 5px;
        border: none;
        overflow-y: auto;
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
    }
    .edit_submit:hover {
        -webkit-animation: neon2 1.5s ease-in-out infinite alternate;
        text-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
    }
    .err_msg {
        display: inline-block;
        width: 100%;
        color: red;
        font-size: 18px;
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