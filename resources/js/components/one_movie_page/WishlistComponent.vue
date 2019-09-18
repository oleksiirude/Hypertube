<template>
    <button id="add" type="button" class="btn btn-success" @click="addToWishlist(action_add)">Add to my wishlist</button>
</template>

<script>
    import axios from 'axios';

    export default {
        props: [
            'action_add',
            'action_delete',
            'wishlist'
        ],

        data: function() {
            return {
                wishlistBoolean: JSON.parse(this.wishlist),
            }
        },

        mounted() {
            // console.log('wishlist component mounted');
            // console.log(this.wishlistBoolean);
        },

        methods: {
            addToWishlist: function (action) {

                axios.post(action, {
                    imdb_id: document.documentURI.split('/')[4],
                }).then(function (response) {
                    if (response.data.result === true) {
                        document.getElementById('add').remove();
                    }
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