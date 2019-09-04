<template>
    <div class="title_info stars" :title="rating + ' / 10'">
        <span class="icon"></span>
        <span class="icon"></span>
        <span class="icon"></span>
        <span class="icon"></span>
        <span class="icon"></span>
    </div>
</template>

<script>
    export default {
        props: [
            'rating'
        ],
        mounted() {
            let inputValue;
            let decimal = 1;
            let val = parseFloat(this.rating);
            let size = val % 5;
            if(size % 1 == 0){
                decimal = 0;
            } else {
                decimal = 1;
            }

            inputValue = (Math.round(size * 2) / 2).toFixed(decimal);
            console.log('test', val, size, inputValue);
            // $.fn.stars = function() {
            //     return $(this).each(function() {
            //         // Get the value
            //         var val = parseFloat($(this).html());
            //         // Make sure that the value is in 0 - 5 range, multiply to get width
            //         var size = Math.max(0, (Math.min(5, val))) * 16;
            //         // Create stars holder
            //         var $span = $('<span />').width(size);
            //         // Replace the numerical value with stars
            //         $(this).html($span);
            //     });
            // };
            // $(function() {
            //     $('span.star').stars();
            // });
        }

    }
</script>

<style scoped>

</style>