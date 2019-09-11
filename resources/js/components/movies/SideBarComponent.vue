<template>
    <div>
        <div class="search_menu" :class="{ open: isOpen, absolute: isAbsolute }" @mouseenter="open_menu" @mouseleave="close_menu">
<!--            Research:-->
            <form method="GET" :action="action">
                <select name="genre" class="browser-default custom-select m-2">
                    <option selected value='all'>{{ trans('genres.all') }}</option>
                    <option value="28">{{ trans('genres.28') }}</option>
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

                {{ trans('titles.productionYear') | capitalize }}:
                <input class="form-control mr-sm-2 w-50 m-1" type="text" placeholder="from" name="year_from" value="1920" hidden>
                <input class="form-control mr-sm-2 w-50 m-1" type="text" placeholder="to" name="year_to" value="2019" hidden>

                <div id="year_slider" class="my_slider"></div>

                {{ trans('titles.minRating') | capitalize }}:
                <select name="min_rating" class="browser-default custom-select m-2" hidden>
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

                <div id="rating_slider" class="my_slider"></div>

                {{ trans('titles.sortBy') | capitalize }}:
                <select name="sort" class="browser-default custom-select m-2">
                    <option value="year" selected> {{ trans('titles.productionYear') | capitalize }}</option>
                    <option value="rating"> {{ trans('titles.rating') | capitalize }}</option>
                </select>
                <select name="order" class="browser-default custom-select m-2">
                    <option value="desc">{{ trans('parts.desc') }}</option>
                    <option value="asc">{{ trans('parts.asc') }}</option>
                </select>

                <button class="research" type="submit">Research it!</button>
            </form>
            <div class="sidebar_right">
            </div>
        </div>
        <div id="menu_open" @mouseenter="open_menu" v-show="!isOpen">
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
                isAbsolute: false,
            }
        },
        props: [
            'action'
        ],
        mounted(){
            this.checkHeight();

            let yearSlider = document.getElementById('year_slider'),
                ratingSlider = document.getElementById('rating_slider');

            noUiSlider.create(yearSlider, {
                start: [1920, 2019],
                connect: true,
                tooltips: true,
                format: {
                    from: function(value) {
                        return parseInt(value);
                    },
                    to: function(value) {
                        return parseInt(value);
                    }
                },
                step: 1,
                range: {
                    'min': 1920,
                    'max': 2019
                }
            });

            noUiSlider.create(ratingSlider, {
                start: 0,
                behaviour: 'tap',
                connect: [false, true],
                tooltips: true,
                format: {
                    from: function(value) {
                        return parseInt(value);
                    },
                    to: function(value) {
                        return parseInt(value);
                    }
                },
                step: 1,
                range: {
                    'min': 0,
                    'max': 10
                }
            });
        },
        methods: {
            checkHeight: function () {
                if(window.innerHeight < 700)
                    this.isAbsolute = true;
                else
                    this.isAbsolute = false;
            },
            open_menu: function () {
              this.isOpen = true;
              console.log('OPEN');
              let films = document.getElementById('movies_list');
              films.style.width = "calc(100% - 280px)";
              films.style.transform = "translateX(260px)";
              this.checkHeight();
            },

            close_menu: function () {
                this.isOpen = false;
                console.log('CLOSE');
                let films = document.getElementById('movies_list');
                films.style.width = "calc(100% - 30px)";
                films.style.transform = "translateX(10px)";
                this.checkHeight();

            },
        },
    }
</script>

<style scoped>
    form {
        padding: 10px;
    }
    select {
        /*border: 1px solid black;*/
        /*color: white;*/
        display: block;
        margin-top: 5px;
        color: #ccc;
        background: rgba(50,50,50,0.75);
        height: 30px;
        /*width: 222px;*/
        line-height: 30px;
        padding: 0 4px;
        border: 0;
        font-size: 14px;
        margin-bottom: 5px;
    }
    .search_menu {
        display: inline-block;
        width:250px;
        padding-top: 20px;
        padding-right: 20px;
        /*padding-bottom: 60px;*/
        color: grey;
        padding-left: 20px;
        /*position: absolute;*/
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
        /*-webkit-transition: left 0.3s;*/
        /*-moz-transition: left 0.3s;*/
        /*transition: left 0.3s;*/
        transition-duration: 0.3s;
        transition-timing-function: ease-in;
        /*min-height: 300px;*/
    }
    .search_menu.absolute {
        position: absolute;
    }
    .sidebar_right {
        width: 30px;
        height: 100%;
        position: absolute;
        top: -20px;
        left: 230px;
        z-index: 99;
    }
    .sidebar_right:hover {
        cursor: context-menu;
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
    .my_slider {
        margin-top: 40px;
        margin-bottom: 20px;
        -webkit-animation: neon2 1.5s ease-in-out infinite alternate;
        text-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
    }
    .research {
        margin-top: 20px;
        margin-bottom: 20px;
        background-color: transparent;
        display: inline-block;
        text-align: center;
        width: 120px;
        height: 50px;
        position: relative;
        color: #fff;
        /*border-radius: 4px;*/
        border: none;
        cursor: pointer !important;
        /*box-shadow: 2px 2px 2px rgba(0, 0, 0, 1);*/
    }
    .research:hover {
        text-decoration: none;
        text-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
    }
</style>