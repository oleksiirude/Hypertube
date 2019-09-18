<template>
    <div class="actors_list" @mouseover="show_img" @mouseleave="hide_img">
        {{ trans('movie.director') | capitalize }}: {{ director_parse.name }}
        <div class="photo_frame" v-if="director_parse.profile_path" v-show="show">
            <img :src="director_parse.profile_path" class="actors_img">
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'director'
        ],
        data: function() {
            return {
                director_parse: JSON.parse(this.director),
                isHidden: true,
                show: false,

            }
        },
        methods: {
            show_img: function () {
               this.show = true;
            },
            hide_img: function () {
                this.show = false;
            },

        },
    }
</script>

<style scoped>
    .actors_img {
        width: 100%;
        height: auto;
        margin-top: -20%;
    }
    .photo_frame {
        display: inline-block;
        width: 50px;
        height: 50px;
        margin: 0 auto;
        overflow: hidden;
        border-radius: 50%;
        background-position: center center;
        background-repeat: no-repeat;
        position: absolute;
    }
</style>>