<template>
    <div class="">
        Cast:
        <ul class="">
            <li v-for="(actor, index) in actors_parse.slice(0,9)" class="actor" @mouseover="show_img(index)" @mouseleave="hide_img(index)">
                {{ actor.name }};
                <div class="photo_frame" v-show="check(index)">
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
            }
        },
        methods: {
            parseData () {
                JSON.parse(this.actors);
            },
            check: function (i) {

            },
            show_img: function () {

            },
            hide_img: function () {

            }
        },
        mounted() {
            console.log('actors', this.actors_parse);
        }

    }
</script>

<style scoped>
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
        width: 80px;
        height: 80px;
        margin: 0 auto;
        overflow: hidden;
        border-radius: 50%;
        background-position: center center;
        background-repeat: no-repeat;
    }
</style>