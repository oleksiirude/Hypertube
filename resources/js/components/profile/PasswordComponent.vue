<template>
    <div>
        <form method="POST" :action="action">
            <label :for="'new_' + name" class="titles">Current password: </label><input type="password" name="password" class="profiledata"><br>
            <label :for="'new_' + name" class="titles">New password: </label><input type="password" name="new_password" class="profiledata"><br>
            <label :for="'new_' + name" class="titles">Confirm password:</label><input type="password" name="password_confirmation" class="profiledata"><br>
        </form>
        <div>
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
            'title_cancel'
        ],
        data: function() {
            return {
                error: '',
                mutableValue: this.value,
                isHidden: true,
                upHere: false,
                // newemail: '',
                // password: ''
            }
        },
        methods: {
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

</style>