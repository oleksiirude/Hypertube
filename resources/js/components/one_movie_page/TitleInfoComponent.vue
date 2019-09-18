<template>
    <div class="title_info_cont">
        <div class="title_info" id="year"><span class="mini_icon"></span> {{ year }}</div>
        <div class="title_info" id="runtime" v-show="!hide"><span class="mini_icon"></span> {{ mutableRuntime }} </div>
        <div class="title_info" id="rating"><span class="mini_icon"><star-component :rating="rating" :rating_nbr="false"></star-component></span><span class="nbr">{{ rating }} / 10</span></div>
        <div class="title_info" id="studio" v-show="studioshow"><span class="mini_icon"></span> {{ studio }}</div>
        <div class="title_info"><img :src="url + '/' + country + '.png'" v-if="country"></div>
    </div>
</template>

<script>
    export default {
        props : [
            'year',
            'runtime',
            'rating',
            'studio',
            'country',
            'url'
        ],
        data: function () {
            return {
                mutableRuntime: this.runtime + ' ' + this.trans('movie.minutes'),
                hide: false,
                studioshow: true,
            }
        },
        mounted() {
            console.log('img', this.country);
            if (this.runtime == 0){
               this.hide = true;
            }
            if (!this.studio) {
                this. studioshow = false;
            }
        }

    }
</script>

<style scoped>
    .title_info_cont {
        margin-bottom: 20px;
    }
    .mini_icon {
        text-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
    }
    #year .mini_icon:before {
        content: '\f073';
        font-family: FontAwesome;
    }
    #runtime .mini_icon:before {
        content: '\f017';
        font-family: FontAwesome;
    }
    #studio .mini_icon:before {
        content: '\f008';
        font-family: FontAwesome;
    }
    .title_info {
        display: inline-block;
        margin-right: 20px;
    }

    .title_info_cont .rating_number {
        display: inline-block;
    }
    .nbr {
        margin-left: -10px;
    }
</style>