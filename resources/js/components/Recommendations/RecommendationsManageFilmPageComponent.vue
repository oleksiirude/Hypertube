<template>
    <div style="display: inline">
        <button type="button" v-if="!recommendationsBoolean" class="btn btn-primary" @click="manageRecommendations(action_add)">{{ trans('titles.recommend') }}</button>
        <button type="button" v-if="recommendationsBoolean" class="btn btn-primary" @click="manageRecommendations(action_delete)">{{ trans('titles.notRecommend') }}</button>
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
                }).catch((error) => {
                        // console.log(error);
                    }
                );
            }
        }
    }
</script>