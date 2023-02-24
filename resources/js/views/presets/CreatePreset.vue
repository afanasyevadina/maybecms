<template>
    <div class="modal fade" id="add-preset" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="save">
                <div class="modal-header">
                    <h5 class="modal-title">Add preset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label>Title</label>
                    <input type="text" required class="form-control" v-model="newPreset.title">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-dismiss="modal" :disabled="!newPreset.title">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CreatePreset',
    data() {
        return {
            newPreset: {}
        }
    },
    methods: {
        save: function () {
            this.postJson(`/api/admin/presets`, this.newPreset, json => this.$router.push(`/presets/${json.data.id}`))
        }
    }
}
</script>
