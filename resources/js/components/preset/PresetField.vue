<template>
    <div class="border p-4 pt-2 mb-4">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center">
                {{ block.title }}
                <a href="#" class="btn btn-sm btn-light" title="Edit block title" data-bs-toggle="modal"
                   :data-bs-target="`#edit-block-${block.id}`">
                    <i class="fas fa-pen"></i>
                </a>
            </div>
            <div class="btn-group">
                <a href="#" class="btn btn-light" title="Delete block" data-bs-toggle="modal"
                   :data-bs-target="`#delete-block-${block.id}`">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        </div>
        <preset-section :editable="block" v-if="block.type == 'section'"></preset-section>
        <component v-else :is="`${block.type}-field`" :block="block" :readonly="true"></component>
        <div class="modal fade" tabindex="-1" :id="`delete-block-${block.id}`">
            <div class="modal-dialog modal-dialog-centered">
                <form action="#" @submit.prevent="$emit('remove')" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>This block will be deleted.</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" :id="`edit-block-${block.id}`">
            <div class="modal-dialog modal-dialog-centered">
                <form action="#" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit block title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" v-model="block.title" required class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" :disabled="!block.title?.trim()">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Block",
    props: {
        block: {
            type: Object
        }
    }
}
</script>
