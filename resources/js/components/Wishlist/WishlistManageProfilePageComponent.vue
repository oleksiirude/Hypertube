<template>
    <div class="container">
        <h2 class="title_wishlist">{{ trans('titles.wishlist') }}</h2>
        <div class="row">
            <div class="col-lg-3 col-6" v-for="(item, index) in wishlistParsed">
                <div :id="item.imdb_id" class="movie">
                    <button class="close" :title="trans('titles.remove')" @click="remove(item.imdb_id, index)">×</button>
                    <a :href="item.link">
                        <img class="movie_poster" :src="item.poster" alt="poster">
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
            'wishlist',
            'action'
        ],

        data: function() {
            return {
                wishlistParsed: JSON.parse(this.wishlist),
            }
        },

        methods: {
            remove: function (imdbId, index) {
                this.wishlistParsed.splice(index, 1);

                // remove entire Vue element from DOM if array is empty
                if (this.wishlistParsed.length < 1) {
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
        top: 2px;
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

    .title_wishlist {
        text-shadow: 2px 2px 2px rgba(0, 0, 0, 1);
        padding: 1.25rem;
        font-size: 28px;
        color: gray;
        text-transform: uppercase;
    }
</style>