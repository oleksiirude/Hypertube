<template>
    <p>{{ box }}</p>
</template>

<script>
    export default {
        props: [
            'motto'
        ],

        data: function () {
          return {
              i: 0,
              box: "",
              splittedMotto: this.motto.split('')
          }
        },

        mounted() {
            let self = this;

            let id = setInterval(function () {
                if (self.i === self.splittedMotto.length - 1)
                    clearInterval(id);

                self.box += self.splittedMotto[self.i];
                self.i++;
            }, 60);

        }
    }
</script>