<template>
    <div class="trailer_div">
        <a class="watch-btn" :href="trailer" target="_blank">
            <div class="icon trailer"></div>
            <div class="caption" >trailer</div>
        </a>
    </div>
</template>

<script>
    export default {
        props: [
            'trailer'
        ],
    }
</script>

<style scoped>
    .trailer_div {
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .watch-btn {
        display: inline-block;
        text-align: center;
        width: 150px;
        height: 60px;
        position: relative;
        color: #fff;
        border-radius: 4px;
        border: 1px rgba(255,255,255, 0.91) solid;
        cursor: pointer !important;
        box-shadow: 2px 2px 2px rgba(0, 0, 0, 1);
    }
    .watch-btn:hover {
        text-decoration: none;
        text-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
    }
    .watch-btn .icon.trailer {
        display: inline-block;
        font-size: 32px;
        line-height: 60px;
    }
    .icon.trailer:before {
        content: '\f144';
        font-family: FontAwesome;
    }
    .caption {
        display: inline-block;
        text-transform: uppercase;
        vertical-align: text-bottom;
        font-size: 0.9rem;
    }
</style>