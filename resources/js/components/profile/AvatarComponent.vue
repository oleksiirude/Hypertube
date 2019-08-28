<template>
    <div>
        <div id="avatar_div">
            <img :src=src :alt=alt class="poster_avatar" @click="choose_file('avatar_label')" id="avatar">
            <button class="destroy" @click="removeAvatar()"></button>
        </div>

        <!--        Change avatar-->
        <form method="POST" enctype="multipart/form-data" :action = action id="change_avatar_form">
            <input type="hidden" name="_token" :value = csrf>
            <input type="file" name="avatar" id="avatar_input" accept=".jpg, .jpeg" @change='submit_form' hidden>
            <label for="avatar_input" id="avatar_label" hidden>choose file</label>
        </form>

        <!--        Delete avatar-->
        <form method="POST" :action = action_delete>
            <input type="hidden" name="_token" :value = csrf>
            <button type="submit">Delete avatar</button>
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
                // choose_label: '<label for="avatar_input" id="avatar_label" hidden>choose file</label>'
            }
        },
        methods: {
            choose_file: function (label_name) {

                document.getElementById(label_name).click();
            },
            submit_form: function () {
                // console.log('click', e);
                document.getElementById('change_avatar_form').submit();
            }
        }
    }
</script>

<style scoped>
    .poster_avatar {
        height: calc(100%);
        top: 0px;
        left: -100px;
        opacity: 1;
        position: absolute;
        -webkit-filter: saturate(116%);
        -webkit-mask-image: -webkit-gradient(linear, right top, left top, color-stop(1,rgba(0,0,0,1)), color-stop(0.5,rgba(0,0,0,1)), color-stop(0,rgba(0,0,0,0)));
        transition-property: opacity;
        transition-duration: 0.2s;
        transition-timing-function: ease-in;
    }
    #avatar:hover {
        cursor: pointer;
    }
    #avatar_div .destroy:after {
        content: '×';
    }
</style>