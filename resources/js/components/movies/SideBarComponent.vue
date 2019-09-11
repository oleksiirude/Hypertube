<template>
    <div>
        <div class="search_menu" :class="{ open: isOpen }" @mouseenter="open_menu" @mouseleave="close_menu">
            Research:
            <form method="GET" :action="action">
                <select name="genre" class="browser-default custom-select m-2">
                    <option value="28" selected>{{ trans('genres.28') }}</option>
                    <option value="12">{{ trans('genres.12') }}</option>
                    <option value="16">{{ trans('genres.16') }}</option>
<!--                    <option value="Biography">{{ trans('genres.Biography') }}</option>-->
                    <option value="35">{{ trans('genres.35') }}</option>
                    <option value="80">{{ trans('genres.80') }}</option>
                    <option value="99">{{ trans('genres.99') }}</option>
                    <option value="18">{{ trans('genres.18') }}</option>
                    <option value="10751">{{ trans('genres.10751') }}</option>
                    <option value="14">{{ trans('genres.14') }}</option>
                    <option value="36">{{ trans('genres.36') }}</option>
                    <option value="27">{{ trans('genres.27') }}</option>
                    <option value="10402">{{ trans('genres.10402') }}</option>
                    <option value="9648">{{ trans('genres.9648') }}</option>
                    <option value="878">{{ trans('genres.878') }}</option>
                    <option value="10770">{{ trans('genres.10770') }}</option>
                    <option value="53">{{ trans('genres.53') }}</option>
                    <option value="10752">{{ trans('genres.10752') }}</option>
                    <option value="37">{{ trans('genres.37') }}</option>
                </select>


                Production year:
                <input class="form-control mr-sm-2 w-50 m-1" type="text" placeholder="from" name="year_from" value="1920">
                <input class="form-control mr-sm-2 w-50 m-1" type="text" placeholder="to" name="year_to" value="2019">

                Minimum Rating:
                <select name="min_rating" class="browser-default custom-select m-2">
                    <option value="0" selected>0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                </select>


                Sort by:
                <select name="sort" class="browser-default custom-select m-2">
                    <option value="year" selected>production year</option>
                    <option value="rating">rating</option>
                </select>
                <select name="order" class="browser-default custom-select m-2">
                    <option value="desc">descending</option>
                    <option value="asc">ascending</option>
                </select>

                <button class="btn btn-secondary m-2" type="submit">Research it!</button>
            </form>
        </div>
        <div id="menu_open" @mouseenter="open_menu">
            <div></div>
            <div></div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                isOpen: false,
            }
        },
        props: [
            'action'
        ],
        methods: {
            open_menu: function () {
              this.isOpen = true;
              console.log('OPEN');
              let films = document.getElementById('movies_list');
              films.style.width = "calc(100% - 260px)";
              films.style.transform = "translateX(260px)"
              // style="transform: translateX(250px);"
            },
            close_menu: function () {
                this.isOpen = false;
                console.log('CLOSE');
                let films = document.getElementById('movies_list');
                films.style.width = "calc(100%)";
                films.style.transform = "translateX(10px)"
                // style="transform: translateX(250px);"
            },
        },
    }
</script>

<style scoped>
    .search_menu {
        display: inline-block;
        width:250px;
        margin-top: 20px;
        margin-right: 20px;
        color: grey;
        padding-left: 20px;
        position: fixed;
        height: 100%;
        /*background: #121212;*/
        /*box-shadow: inset -21px 0px 50px 0px rgba(0,0,0, 1);*/
        opacity: 0;
        top: 100px;
        left: -230px;
        box-sizing: border-box;
        /*border-right: 1px rgba(255,255,255,0.15) solid;*/
        /*transition-property: *;*/
        -webkit-transition: left 0.3s;
        -moz-transition: left 0.3s;
        transition: left 0.3s;
        /*transition-duration: 0.12s;*/
        /*transition-timing-function: ease-in;*/
    }
    .search_menu.open {
        left: 0 !important;
        opacity: 1;
    }
    #menu_open {
        cursor: pointer;
        position: fixed;
        width: 23px;
        height: 60px;
        background: #000;
        opacity: 0.9;
        top: calc(50% - 30px);
        left: -4px;
        border-radius: 4px;
        box-shadow: 0px 0px 15px 0px rgba(0,0,0,1);
        border: 1px #444 solid;
        box-sizing: border-box;
        padding: 5px;
    }
    #menu_open div {
        width: 2px;
        height: 100%;
        background: #fff;
        margin-left: 3px;
        opacity: 0.75;
        float: left;
        box-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
    }
</style>