<template>
    <div>
        <button type="button" v-if="!wishlistBoolean" class="btn btn-success" @click="manageWishlist(action_add)">Add to wishlist</button>
        <button type="button" v-if="wishlistBoolean" class="btn btn-danger" @click="manageWishlist(action_delete)">Delete from wishlist</button>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        mounted () {
            let self = this;

            setTimeout(function() {
                axios.post(self.action_history, { imdb_id: self.imdb_id });
            }, 20000);
        },

        props: [
            'imdb_id',
            'action_add',
            'action_delete',
            'action_history',
            'wishlist'
        ],

        data: function() {
            return {
                wishlistBoolean: JSON.parse(this.wishlist),
            }
        },

        methods: {
            manageWishlist: function (action) {
                let self = this;
                axios.post(action, {
                    imdb_id: self.imdb_id,
                }).then(function (response) {
                    self.wishlistBoolean = response.data.result;
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