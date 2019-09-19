<template>
    <div class="container">
        <h2 class="title_topic">{{ trans('titles.history') }}</h2>
        <div id="title_topic" class="row">
            <div class="col-2 movie_main_div" v-for="(item, index) in historyParsed">
                <div :id="item.imdb_id" class="movie">
                    <button class="close" :title="trans('titles.remove')" @click="remove(item.imdb_id, index)">×</button>
                    <a :href="item.link">
                        <img class="thumbnail_movie" :src="item.poster" alt="poster">
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: [
            'history',
            'action'
        ],

        data: function() {
            return {
                historyParsed: JSON.parse(this.history),
            }
        },

        methods: {
            remove: function (imdbId, index) {
                this.historyParsed.splice(index, 1);

                // remove entire Vue element from DOM if array is empty
                if (this.historyParsed.length < 1) {
                    this.$destroy();
                    this.$el.parentNode.removeChild(this.$el);
                }

                axios.post(this.action, { imdb_id: imdbId });
            }
        }
    }
</script>

<style scoped>
    .container {
        background-color: #282828;
        border-radius: 4px;
        margin-top: 10px
    }

    .close {
        width: 20px;
        height: 20px;
    }
    .movie {
        position: relative;
        display: inline-block;
        font-size: 0;
    }

    .movie .close {
        position: absolute;
        right: 2px;
        z-index: 999;
        color: #000;
        font-weight: bold;
        cursor: pointer;
        opacity: 0.1;
        text-align: center;
        font-size: 22px;
        line-height: 10px;
        border-radius: 50%;
    }

    .movie:hover .close {opacity: 1;}

    .close:hover {color: darkred;}

    .thumbnail_movie {
        width: 100%;
    }
</style>