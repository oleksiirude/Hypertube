<template>
    <div class="top-right links">
        <div class="language">
            <a :href="en_url">
                <img :src="en_img" id="en" alt="English" v-bind:class=" {active_lng: ('en' === currentLang)} ">
            </a>
            <a :href="ua_url">
                <img :src="ua_img" id="ua" alt="Ukrainian" v-bind:class=" {active_lng: ('ua' === currentLang)} ">
            </a>
            <a :href="ru_url">
                <img :src="ru_img" id="ru" alt="Russian" v-bind:class=" {active_lng: ('ru' === currentLang)} ">
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        mounted(){

        },
        props: [
            'ua_url',
            'en_url',
            'ua_img',
            'en_img',
            'ru_url',
            'ru_img',
        ],
        data: function () {
            return {
                currentLang: document.documentElement.lang
            }
        }
    }
</script>

<style scoped>
    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
        z-index: 11;
    }
    .top-right {
        display: inline-block;
        float: right;
    }
    .language {
        margin-right: 20px;
    }
    .language > a > img {
        opacity: 0.4;
    }
    .language > a > img:hover {
        opacity: 1.0;
    }
    .language > a > .active_lng {
        opacity: 1.0;
    }


</style>