<template>
    <div class="modal fade" :id="`delete-model-${this.id}`" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="remove">
                <div class="modal-header">
                    <h5 class="modal-title">Delete model</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This model will be deleted
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
    name: 'DeletePostType',
    props: ['id'],
    methods: {
        remove: function () {
            this.deleteRequest(`/api/admin/post-types/${this.id}`,() => {
                    this.$router.push('/post-types')
                    location.reload()
                })
        }
    }
}
</script>
