<template>
    <footer>
        <div class="upper_footer"></div>
        <div class="footer_content">
            <p class="copyright">
                &copy; created by US, 2019
            </p>
            <lang-component :ua_url="ua_url"
                            :ua_img="ua_img"
                            :ru_url="ru_url"
                            :ru_img="ru_img"
                            :en_url="en_url"
                            :en_img="en_img"
                            id="footer_lang"
            ></lang-component>
        </div>
    </footer>
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
        height: 120px;
        left: 0;
        right: 0;
        /*bottom: 40px;*/
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


</style>