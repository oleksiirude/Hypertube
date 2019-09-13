<template>
    <div class="genres_list">
        <div v-for="(genre, index) in genres_parse" class="genre">
            {{ trans('genres.' + genre ) }}
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'genres',
        ],
        data: function() {
            return {
                genres_parse: JSON.parse(this.genres),
            }
        },
        parseData () {
            JSON.parse(this.genres);
        },
        mounted() {
            console.log('genres', this.genres_parse);
        }
    }
</script>

<style scoped>
    .genres_list {
        margin-bottom: 10px;
        font-size: 12px;
    }
    .genre {
        display: inline-block;
        margin-right: 20px;
    }
</style>