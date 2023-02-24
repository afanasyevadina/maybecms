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
    name: "DeleteModal",
    props: {
        block: {
            type: Object
        },
        modalKey: {
            type: String
        }
    },
    data() {
        return {
            primitives: [],
            presets: []
        }
    },
    methods: {
        remove: function () {
            this.deleteRequest(`/api/admin/blocks/${this.block.id}`, () => {
                this.hideModal()
                this.$emit('remove')
            })
        }
    },
    mounted() {
        this.getJson(`/api/admin/primitives`, json => this.primitives = json.data)
        this.getJson(`/api/admin/presets`, json => this.presets = json.data)
    }
}
</script>
