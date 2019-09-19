<template>
    <div>
        <button type="button" v-if="!recommendationsBoolean" class="btn btn-success" @click="manageRecommendations(action_add)">Recommend</button>
        <button type="button" v-if="recommendationsBoolean" class="btn btn-danger" @click="manageRecommendations(action_delete)">Not recommend</button>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: [
            'imdb_id',
            'action_add',
            'action_delete',
            'recommendations'
        ],

        data: function() {
            return {
                recommendationsBoolean: JSON.parse(this.recommendations),
            }
        },

        methods: {
            manageRecommendations: function (action) {
                let self = this;
                axios.post(action, {
                    imdb_id: self.imdb_id,
                }).then(function (response) {
                    self.recommendationsBoolean = response.data.result;
                }).catch((error) =>
                    console.log(error)
                );
            }
        }
    }
</script>

<style scoped>
    .btn-success {
        background-color: #1f5335;
        border-color: #000;
    }

    .btn-success:hover {
        background-color: #2fa360;
        border-color: #2d995b;
    }
</style>