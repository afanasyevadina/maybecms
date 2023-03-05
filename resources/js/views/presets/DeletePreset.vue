<template>
    <div class="modal fade" :id="`delete-preset-${this.id}`" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="remove">
                <div class="modal-header">
                    <h5 class="modal-title">Delete page</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This preset will be deleted
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

export default {
    name: 'DeletePreset',
    props: ['id'],
    methods: {
        remove: function () {
            this.deleteRequest(`/api/presets/${this.id}`,() => {
                    this.$router.push({ name: 'Presets' })
                    location.reload()
                })
        }
    }
}
</script>
