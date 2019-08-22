<template>
    <footer>
        <div class="upper_footer"></div>
        <div class="footer_content">
            <p class="copyright">
                &copy; created by US, 2019
            </p>
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
        </div>
    </footer>
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
        name: "FooterComponent.vue",
        props: [
            'ua_url',
            'en_url',
            'ua_img',
            'en_img',
        ],
    }
</script>

<style scoped>
    footer {
        width: 100%;
        height: 160px;
        color: #fff;
        background: black;

        text-align: right;
    }
    .footer_content {
        text-align: left;
    }
    .copyright {
        display: inline-block;
        text-align: left;
        padding-left: 20px;
        /*padding-top: 10px;*/
        opacity: 0.5;
    }
    footer::before {
        content: '';
        position: absolute;
        /*top: 0;*/
        height: 140px;
        left: 0;
        right: 0;
        bottom: 40px;
        z-index: 10;
        background-image: -webkit-gradient(linear,left top,right top,color-stop(10%,#221f1f),color-stop(85%,rgba(0,0,0,0)));
        background-image: -webkit-linear-gradient(to top,#221f1f 10%,rgba(0,0,0,0) 85%);
        background-image: -moz- oldlinear-gradient(to top,#221f1f 10%,rgba(0,0,0,0) 85%);
        background-image: -o-linear-gradient(to top,#221f1f 10%,rgba(0,0,0,0) 85%);
        background-image: linear-gradient(to bottom,#221f1f 10%,rgba(0,0,0,0) 85%);
        zoom: 1;
    }
    .upper_footer {
        content: "";
        height: 120px;
        background: url(/images/service/cinema.jpg) repeat-x;
        background-size: contain;
        z-index: -1;

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