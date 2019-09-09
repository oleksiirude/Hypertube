<template>
    <div class="">
        {{ trans('movie.cast') | capitalize }}:
        <ul class="movies_list">
            <li v-for="(actor, index) in actors_parse.slice(0,9)" class="actor" @mouseover="show_img(index)" @mouseleave="hide_img(index)">
                {{ actor.name }};
                <div class="photo_frame" v-if="actor.profile_path" v-show="show[index]">
                    <img :src="path + actor.profile_path" class="actors_img">
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: [
            'actors',
            'path'
        ],
        data: function() {
            return {
                actors_parse: JSON.parse(this.actors),
                isHidden: true,
                show: [false, false, false, false, false, false, false, false, false],
            }
        },
        methods: {
            parseData () {
                JSON.parse(this.actors);
            },
            show_img: function (index) {
                // this.isHidden = false;
                Vue.set(this.show, index, true);
                // console.log(this.show);
                // console.log(this.show[index]);
            },
            hide_img: function (index) {
                Vue.set(this.show, index, false);
            }
        },
        mounted() {
            console.log('actors', this.actors_parse);
        }

    }
</script>

<style scoped>
    .movies_list {
        padding-right: 80px;
    }
    .actor {
        display: inline-block;
        margin-right: 10px;
        font-size: 12px;
    }
    .actor:hover {
        -webkit-animation: neon2 1.5s ease-in-out infinite alternate;
        text-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
    }
    .actors_img {
        width: 100%;
        height: auto;
        margin-top: -20%;
    }
    .photo_frame {
        display: inline-block;
        width: 60px;
        height: 60px;
        margin: 0 auto;
        overflow: hidden;
        border-radius: 50%;
        background-position: center center;
        background-repeat: no-repeat;
        position: absolute;
        /*top: 0px;*/
        /*left:20px;*/
    }
</style>