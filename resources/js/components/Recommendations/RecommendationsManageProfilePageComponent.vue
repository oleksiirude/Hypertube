<template>
    <div class="container">
        <h2 class="title_topic">{{ trans('titles.recommendations') }}</h2>
        <div v-if="recommendationsParsed.length" id="movies_catalog" class="row">
            <div class="col-2 movie_main_div" v-for="(item, index) in recommendationsParsed">
                <div :id="item.imdb_id" class="movie">
                    <button v-if="propertyParsed" class="close" :title="trans('titles.remove')" @click="remove(item.imdb_id, index)">×</button>
                    <a :href="item.link">
                        <img class="movie_poster" :src="item.poster" alt="poster">
                    </a>
                </div>
            </div>
        </div>
        <div v-else>
            <p class="empty">{{ trans('titles.noRecommendations') }}</p>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: [
            'recommendations',
            'property',
            'action'
        ],

        mounted () {

        },

        data: function() {
            return {
                recommendationsParsed: JSON.parse(this.recommendations),
                propertyParsed: JSON.parse(this.property),
                empty: [this.trans('titles.noRecommendations')]
            }
        },

        methods: {
            remove: function (imdbId, index) {
                this.recommendationsParsed.splice(index, 1);

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
</style>