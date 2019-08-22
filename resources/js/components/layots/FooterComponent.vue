<template>
    <footer>
        <p class="copyright">
            &copy; created by US, 2019
        </p>
    </footer>
</template>

<script>
    export default {
        name: "FooterComponent.vue"
    }
</script>

<style scoped>
    footer {
        width: 100%;
        height: 80px;
        color: #fff;
        background: #141414;

        text-align: right;
    }
    .copyright {
        text-align: left;
        padding-left: 20px;
        padding-top: 10px;
        opacity: 0.5;
    }

</style>