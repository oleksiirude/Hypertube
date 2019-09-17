<template>
    <VuePlyr ref="player">
        <video crossorigin>
            <source v-if="videoSrcs.hd" :src="`http://localhost:3000/api/stream/${videoSrcs.hd}`" size="720" type="video/mp4" default>
            <source v-if="videoSrcs.full" :src="`http://localhost:3000/api/stream/${videoSrcs.full}`" size="1080" type="video/mp4">
            <track v-for="(sub, lang) in subtitles" :src="`http://localhost:3000/${sub}`" :srclang="lang" :label="lang">
        </video>
        {{videoSrcs}}
        {{subtitles}}
    </VuePlyr>
</template>

<script>
    import { VuePlyr } from "vue-plyr";
    import "vue-plyr/dist/vue-plyr.css";
    //TODO исправить попытку получить субтитры до того как прийдет ответ от субтитров API
    //TODO refactoring!
    export default {
        name: "VideoPlayerComponent",
        components : {
            VuePlyr
        },
        data() {
            return {
                player: null,
                subtitles: {
                    en: null,
                    ru: null,
                    uk: null
                },
            }
        },
        props: {
            videoSrcs: {
                type: Object,
                require: true
            },
            imdbId: {
                type: String,
                default: null
            },
        },
        methods: {
          getSubs() {
            return axios
                .get(`http://localhost:3000/api/subtitles/${this.imdbId}`)
                .then(res => this.subtitles = res.data)
                .catch(() => console.log('subtitles not found'));
          },
        },
        beforeMount() {
            this.getSubs();
        },
        mounted() {
            this.player = this.$refs.player.player;
            console.log(this.subtitles);
        }
    }
</script>

<style scoped>

</style>