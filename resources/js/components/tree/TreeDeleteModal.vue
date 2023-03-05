<template>
    <div class="modal fade" tabindex="-1" :id="modalKey">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" @submit.prevent="remove" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>This block will be deleted.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "TreeDeleteModal",
    props: {
        block: {
            type: Object
        },
        modalKey: {
            type: String
        }
    },
    methods: {
        remove: function () {
            this.deleteRequest(`/api/blocks/${this.block.id}`, () => {
                this.hideModal()
                this.$emit('update')
            })
        }
    }
}
</script>
