<template>
    <div class="modal fade" id="add-model" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="save">
                <div class="modal-header">
                    <h5 class="modal-title">Add model</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label>Title</label>
                    <input type="text" required class="form-control" v-model="newModel.title">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-dismiss="modal" :disabled="!newModel.title">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CreatePostType',
    data() {
        return {
            newModel: {}
        }
    },
    methods: {
        save: function () {
            this.postJson(`/api/post-types`, this.newModel, () => location.reload())
        }
    }
}
</script>
