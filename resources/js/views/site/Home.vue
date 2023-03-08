<template>
    <preview-item :block="page"></preview-item>
</template>

<script>
export default {
    name: "Home",
    props: ['id'],
    data() {
        return {
            page: {}
        }
    },
    methods: {
        loadPage: function () {
            this.page = {}
            this.getJson(`/api/pages/home`, json => this.page = json.data)
        }
    },
    mounted() {
        this.loadPage()
    }
}
</script>

<style scoped>

</style>
