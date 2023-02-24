<template>
    <div class="d-flex align-items-center tree-node">
        <a href="#" class="py-1 btn btn-sm w-100 text-start border-0" @click.prevent="$emit('activate', block)">{{ block.title }}</a>
        <button class="btn border-0 btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-vertical"></i>
        </button>
        <ul class="dropdown-menu py-0">
            <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#delete-modal-${collapseKey}`">Delete</a></li>
        </ul>
        <DeleteModal @remove="$emit('remove')" :modalKey="`delete-modal-${collapseKey}`" :block="block"></DeleteModal>
    </div>
</template>

<script>
import DeleteModal from "./DeleteModal.vue";
export default {
    name: "TreePrimitive",
    components: {DeleteModal},
    props: {
        block: {
            type: Object
        },
        depth: {
            type: Number
        },
        order: {
            type: Number
        }
    },
    computed: {
        collapseKey: function () {
            return this.depth * 10 + this.order
        }
    },
}
</script>
<style scoped>
.tree-node:not(:hover) .dropdown-toggle {
    display: none;
}
.tree-node:hover {
    background-color: #f8f9fa;
}
</style>
