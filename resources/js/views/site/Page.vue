<template>
    <preview-item :block="page"></preview-item>
</template>

<script>
export default {
    name: "Page",
    props: ['id'],
    data() {
        return {
            page: {}
        }
    },
    methods: {
        loadPage: function () {
            this.page = {}
            this.getJson(`/api/pages/${this.id}`, json => this.page = json.data)
        }
    },
    mounted() {
        this.loadPage()
    }
}
</script>

<style scoped>

</style>
