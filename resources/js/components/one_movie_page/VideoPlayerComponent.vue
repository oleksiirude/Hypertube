<template>
    <VuePlyr v-if="!loading" ref="player">
        <video crossorigin>
            <source v-if="videoSrcs.hd" :src="`http://localhost:3000/api/stream/${videoSrcs.hd}`" size="720" type="video/mp4" default>
            <source v-if="videoSrcs.full" :src="`http://localhost:3000/api/stream/${videoSrcs.full}`" size="1080" type="video/mp4">
            <track v-for="(sub, lang) in subtitles" :src="`http://localhost:3000/${sub}`" :srclang="lang" :label="lang">
        </video>
<!--        {{videoSrcs}}-->
<!--        {{subtitles}}-->
    </VuePlyr>
    <div v-else class="loader-container">
        <img src="http://186.237.228.34:4010/portal_unimed/images/Load.gif" class="loader" alt="loading">
    </div>
</template>

<script>
    import { VuePlyr } from "vue-plyr";
    import "vue-plyr/dist/vue-plyr.css";

    export default {
        name: "VideoPlayerComponent",
        components : {
            VuePlyr
        },
        data() {
            return {
                player: null,
                subtitles: {},
                loading: true
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
            async getSubs() {
                return await axios
                    .get(`http://localhost:3000/api/subtitles/${this.imdbId}`)
                    .then(res => {
                        this.loading = false;
                        return this.subtitles = res.data;
                    })
                    .catch(() => {
                        // console.log('subtitles not found');
                        this.loading = false;
                    });
            },
            addLoop: function () {
                let img = document.createElement('img');
                img.src = "http://186.237.228.34:4010/portal_unimed/images/Load.gif";
                img.width = 50;
                return img;
            }
        },
        created() {
            this.getSubs();
        },
<<<<<<< HEAD
=======
        mounted() {
        }
>>>>>>> a9fad93a54398f56ccedd906e4a7f0e888e2db48
    }
</script>

<style scoped>
    .loader {
        width: 10%;
    }
    .loader-container {
        text-align: center;
    }
</style>