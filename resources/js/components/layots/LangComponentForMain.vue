<template>
    <div class="top-right links">
        <div class="language">
            <a :href="en_url">
                <img :src="en_img" id="en" alt="English">
            </a>
            <a :href="ua_url">
                <img :src="ua_img" id="ua" alt="Ukrainian">
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        mounted(){
            let lang = document.documentElement.lang;
            if (lang === 'ua') {
                document.getElementById('ua').classList.add("active_lng");
            }
            else {
                document.getElementById('en').classList.add("active_lng");
            }
            console.log('lang', document.documentElement.lang);
        },
        props: [
            'ua_url',
            'en_url',
            'ua_img',
            'en_img',
        ],
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