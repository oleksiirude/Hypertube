<template>
    <div class="container">
        <div class="nav-item dropdown search_div" v-click-outside="outside" style="float: right">
            <div class="search_form" v-show="!isHidden" id="search_form_upper">
                <input class="form-control" type="text"
                       :placeholder="trans('titles.search')  + ' ' + trans('titles.searchFilms') + '...' | capitalize"
                       name="title" id="search_input"
                       autocomplete="off"
                       v-show="!isHidden"
                       @keyup="find_match">
            </div>
            <div id="huge_list" class="searchsuggestions" v-show="!isHidden">
                <a v-for="(film, index) in films" class="film_suggestion" :href="film.link">
                    <div class="poster_film" v-if="film.poster">
                        <img :src="film.poster" class="film_img">
                    </div>
                    <div class="title_film">
                        {{ film.title }}<br>
                        <star-component :rating="film.rating" :rating_nbr="false"></star-component>
                    </div>
                    <span class="movie_year">{{ film. prod_year}}</span>
                </a>
            </div>
            <div class="icon search" :title="trans('titles.search')" @mouseover="show_search()">
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'action'
        ],
        data: function() {
            return {
                isHidden: true,
                films: [],
                // no_result = {{ trans('titles.noResults') }},
            }
        },
        directives: {
            'click-outside': {
                bind: function(el, binding, vNode) {
                    // Provided expression must evaluate to a function.
                    if (typeof binding.value !== 'function') {
                        const compName = vNode.context.name;
                        let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`;
                        if (compName) { warn += `Found in component '${compName}'` };

                        console.warn(warn);
                    }
                    // Define Handler and cache it on the element
                    const bubble = binding.modifiers.bubble
                    const handler = (e) => {
                        if (bubble || (!el.contains(e.target) && el !== e.target)) {
                            binding.value(e)
                        }
                    }
                    el.__vueClickOutside__ = handler;

                    // add Event Listeners
                    document.addEventListener('click', handler);
                },

                unbind: function(el, binding) {
                    // Remove Event Listeners
                    document.removeEventListener('click', el.__vueClickOutside__);
                    el.__vueClickOutside__ = null;

                }
            }
        },
        methods: {
            show_search: function () {
                this.isHidden = false;
            },
            // hide_search: function () {
            //     this.isHidden = true;
            // },
            outside: function(e) {
                this.isHidden = true;
                console.log('outside');
            },
            find_match: function (event) {
                let input = event.target;
                let min_characters = 2;
                let self = this;
                let info = input.value;
                axios.get(self.action + '?title=' + info)
                    .then(function (response){
                        let res = response.data;
                        if (res.result === true)
                        {
                            console.log('true RESP', res.data);
                            let response = res.data;
                            self.films = response;
                        }
                        else {
                            // if (input.value.length >= min_characters ) {
                            //     self.films[0] = trans('titles.noResults');
                            // }
                            // else
                                self.films = [];
                            // self.error = response.data.error;
                        }
                        console.log('RESP', response.data);
                    })
                    .catch((error) =>
                        console.log(error)
                    );
            },

        }
    }
</script>

<style scoped>
    .search_div {
        display: flex;
    }
    .search_form_upper {
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
        display: inline-block;
        width: 100%;
        height: 100%;
        font-size: 14px;
        color: rgba(255,255,255,0.8);
        right: 2px;
        top: 0;
        background: #4f4d4c;
        border: 0;
        transition-duration: 0.2s;
        transition-timing-function: ease-in;
    }
    ::placeholder {
        color: rgba(255,255,255,0.6);
        opacity: 1;
    }
    #search_input:focus {
        color: rgba(255,255,255,0.9);
        outline: 0;
    }
    .searchsuggestions {
        width: 240px;
        position: absolute;
        top: 50px;
        left: 0px;
        z-index: 10;
        background: linear-gradient(to left, rgba(255,255,255,0.1) 0%,rgba(255,255,255,0.3) 79%,rgba(255,255,255,0.5) 100%);
    }

</style>
<style>
    .searchsuggestions a{
        position: relative;
        display: flex;
        background-color: #141414;
        padding: 2px 2px 2px 2px;
        margin: 0px 0 5px 0;
        display: block;
        clear: left;
        color: white;
        height: auto;
        text-decoration: none;
    }
    .searchsuggestions a:hover{
        color: white;
        cursor: pointer;
        text-shadow: 0 0 5px #228DFF, 0 0 10px #228DFF, 0 0 15px #228DFF, 0 0 20px #fff, 0 0 35px #fff, 0 0 40px #228DFF, 0 0 50px #228DFF, 0 0 75px #228DFF;
    }
    .poster_film {
        display: inline-block;
        position: relative;
        width: 50px;
        padding-left: 5px;
    }
    .title_film {
        font-size: 14px;
        vertical-align: middle;
        padding-left: 5px;
        padding-right: 5px;
        display: inline-block;
        width: 180px;
    }
    .film_img {
        width: 100%;
    }
    .searchsuggestions .movie_year {
        position: absolute;
        background-color: grey;
        top: 50px;
        left: 190px;
        font-size: 10px;
        border-radius: 4px;
        padding: 1px 3px;
        opacity: 0.8;
    }

</style>