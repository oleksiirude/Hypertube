<template>
    <div class="title_info stars" :title="rating + ' / ' + maxRating">
        <span v-for="star in maxStars" class="icon" :class="check_class(star)"></span>
        <span class="rating_number" v-show="show">{{ rating }} / {{ maxRating }}</span>
    </div>
</template>

<script>
    export default {
        props: [
            'rating',
            'rating_nbr'
        ],
        data() {
            return {
                show: this.rating_nbr,
                full_stars: Math.floor(parseFloat(this.rating) / 2),
                maxStars: 5,
                maxRating: 10,
                half_star: 0,
                ost: 5 - this.full_stars,
                empty: 0,
                count: 0
            }
        },
        mounted() {
            let etc_star;
            let decimal = 1;
            let val = parseFloat(this.rating);
            let tmp_star = val % 2;
            if(tmp_star % 1 == 0)
                decimal = 0;
            else
                decimal = 1;
            etc_star = (Math.round((tmp_star) )).toFixed(decimal);
            if (etc_star == 2)
                this.full_stars++;
            else if (etc_star == 1) {
                this.half_star = 1;
                this.count = this.full_stars + 1;
            }

        },
        methods: {
            check_class: function (i) {

                if (i <= this.full_stars)
                    return ('star');
                else if (i == this.count && this.half_star == 1 )
                    return ('star_half');
                else
                    return ('star_empty');
            }
        }

    }
</script>

<style scoped>

    .icon.star:before {
        content: '\f005';
        font-family: FontAwesome;
    }
    .icon.star_half:before {
        content: '\f123';
        font-family: FontAwesome;
    }
    .icon.star_empty:before {
        content: '\f006';
        font-family: FontAwesome;
    }
    .rating_number {
        display: block;
    }
</style>