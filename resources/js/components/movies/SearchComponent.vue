<template>
    <li class="nav-item dropdown search_div">
        <form class="search_form" :action="action" v-show="!isHidden">
            <input class="" type="text" placeholder="Search films..." name="title" id="search_input" autocomplete="off" v-show="!isHidden" @blur="hide_search()" @mouseleave="hide_search()">
            <!--            <button class="btn btn-secondary" type="submit">Go!</button>-->
        </form>
        <div class="icon search" :title="trans('titles.search')" @mouseover="show_search()">
        </div>

    </li>
</template>

<script>
    export default {
        props: [
            'action'
        ],
        data: function() {
            return {
                isHidden: true,
                // title : trans('titles.search')
            }
        },
        methods: {
            show_search: function () {
                this.isHidden = false;
//                console.log('show');
            },
            hide_search: function () {
                this.isHidden = true;
            }
        }
    }
</script>

<style scoped>
    .search_div {
        display: flex;
    }
    .search_form {
        /*margin: auto;*/
        width: 200px;
        background: linear-gradient(to left, rgba(255,255,255,0) 0%,rgba(255,255,255,0.35) 79%,rgba(255,255,255,0.45) 100%);
        padding-left: 10px;
    }
    .search {
        margin: auto;
        margin-right: 20px;
        margin-left: 10px;
    }
    .icon.search:before {
        content: "\f002";
        font-family: FontAwesome;
        cursor: pointer;
    }

    .icon.search:hover {
        -webkit-animation: neon2 1.5s ease-in-out infinite alternate;
        text-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
    }
    #search_input{
        vertical-align: middle;
        /* margin: auto; */
        display: inline-block;
        width: 100%;
        height: 100%;
        /*display: none;*/
        /*position: absolute;*/
        /*width: calc(100% - 30px);*/
        /*height: 100%;*/
        /*line-height: 16px;*/
        font-size: 14px;
        color: rgba(255,255,255,0.8);
        right: 2px;
        top: 0;
        background: transparent;
        /*background: #221f1f;*/
        border: 0;
        transition-duration: 0.2s;
        transition-timing-function: ease-in;
    }
    ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: rgba(255,255,255,0.6);
        opacity: 1; /* Firefox */
    }
    #search_input:focus {
        color: rgba(255,255,255,0.9);
        /*background: #221f1f;*/
        /*border-color: #e6e6e6;*/
        outline: 0;
        /*box-shadow: 0 0 0 0.2rem rgba(236, 236, 236, 0.2);*/
    }
</style>