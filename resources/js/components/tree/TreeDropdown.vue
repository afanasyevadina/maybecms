<template>
<div>
    <button class="btn border-0 btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-ellipsis-vertical"></i>
    </button>
    <ul class="dropdown-menu py-0">
        <template v-if="block.type === 'section'">
            <li><a class="dropdown-item small px-2" href="#" @click.prevent="addBlock({type:'section', title: 'Section'})">Add section</a></li>
            <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#add-primitive-${collapseKey}`">Add primitive</a></li>
            <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#add-preset-${collapseKey}`">Add preset</a></li>
        </template>
        <li><a class="dropdown-item small px-2" href="#" @click.prevent="cloneBlock">Clone</a></li>
        <li><a class="dropdown-item small px-2" href="#" @click.prevent="$emit('moveUp')" v-if="block.order > 1">Move up</a></li>
        <li><a class="dropdown-item small px-2" href="#" @click.prevent="$emit('moveDown')" v-if="block.order < count">Move down</a></li>
        <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#delete-modal-${collapseKey}`">Delete</a></li>
    </ul>
    <TreeDeleteModal @update="$emit('update')" :modalKey="`delete-modal-${collapseKey}`" :block="block"></TreeDeleteModal>
    <TreeAddPrimitiveModal @addBlock="addBlock" :modalKey="`add-primitive-${collapseKey}`"></TreeAddPrimitiveModal>
    <TreeAddPresetModal @addPreset="addPreset" :modalKey="`add-preset-${collapseKey}`"></TreeAddPresetModal>
</div>
</template>

<script>
import TreeDeleteModal from "./TreeDeleteModal.vue";
import TreeAddPrimitiveModal from "./TreeAddPrimitiveModal.vue";
import TreeAddPresetModal from "./TreeAddPresetModal.vue";
export default {
    name: "TreeDropdown",
    components: {TreeDeleteModal, TreeAddPresetModal, TreeAddPrimitiveModal},
    props: {
        block: {
            type: Object
        },
        depth: {
            type: Number
        },
        order: {
            type: Number
        },
        count: {
            type: Number
        }
    },
    computed: {
        collapseKey: function () {
            return this.depth * 10 + this.order
        }
    },
    methods: {
        cloneBlock: function () {
            this.postJson(`/api/blocks/${this.block.id}/clone`, {}, () => {
                this.$emit('update')
            })
        },
        addBlock: function (block) {
            this.postJson(`/api/blocks`, {
                title: block.title,
                type: block.type,
                attachable_id: this.block.id,
                attachable_type: this.block.class_name,
            }, json => {
                this.block.blocks?.push(json.data)
                this.$emit('activate', this.block.blocks[this.block.blocks.length - 1])
            })
        },
        addPreset: function (preset) {
            this.postJson(`/api/presets/${preset.id}/apply`, {
                attachable_type: this.block.class_name,
                attachable_id: this.block.id,
            }, json => {
                this.block.blocks = this.block.blocks?.concat(json.data)
            })
        }
    }
}
</script>
