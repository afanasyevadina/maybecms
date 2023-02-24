<template>
    <div class="modal fade" :id="`delete-post-${this.id}`" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="remove">
                <div class="modal-header">
                    <h5 class="modal-title">Delete page</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This post will be deleted
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
    name: 'DeletePage',
    props: ['id'],
    methods: {
        remove: function () {
            this.deleteRequest(`/api/admin/posts/${this.id}`,() => {
                    this.$router.push(`/${this.postType}`)
                    location.reload()
                })
        }
    }
}
</script>
