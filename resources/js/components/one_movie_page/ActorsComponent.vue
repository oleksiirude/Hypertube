<template>
    <div class="actors_list">
        {{ trans('movie.cast') | capitalize }}:
        <ul class="movies_list">
            <li v-for="(actor, index) in actors_parse.slice(0,9)" class="actor" @mouseover="show_img(index)" @mouseleave="hide_img(index)">
                {{ actor.name }};
<!--                <span @show="currentLang =='ru'">{{ latin_to_cyrill(actor.name) }}</span>-->
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
                // currentLang: document.documentElement.lang,
                // arrru : new Array ('Я','я','Ю','ю','Ч','ч','Ш','ш','Щ','щ','Ж','ж','А','а','Б','б','В','в','Г','г','Д','д','Е','е','Ё','ё','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н', 'О','о','П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ы','ы','Ь','ь','Ъ','ъ','Э','э'),
                // arren : new Array ('Ya','ya','Yu','yu','Ch','ch','Sh','sh','Sh','sh','Zh','zh','A','a','B','b','V','v','G','g','D','d','E','e','E','e','Z','z','I','i','J','j','K','k','L','l','M','m','N','n', 'O','o','P','p','R','r','S','s','T','t','U','u','F','f','H','h','C','c','Y','y','`','`','\'','\'','E', 'e'),

        }
        },
        methods: {
            parseData () {
                JSON.parse(this.actors);
            },
            show_img: function (index) {
                Vue.set(this.show, index, true);
            },
            hide_img: function (index) {
                Vue.set(this.show, index, false);
            },
            // latin_to_cyrill: function (text){
            //     for(var i=0; i<this.arren.length; i++){
            //         var reg = new RegExp(this.arren[i], "g");
            //         text = text.replace(reg, this.arrru[i]);
            //     }
            //     return text;
            // }
        },
        mounted() {
            console.log('actors', this.actors_parse);

        }
    }
</script>

<style scoped>
    .movies_list {
        padding-right: 10px;
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
        width: 50px;
        height: 50px;
        margin: 0 auto;
        overflow: hidden;
        border-radius: 50%;
        background-position: center center;
        background-repeat: no-repeat;
        position: absolute;
    }
</style>