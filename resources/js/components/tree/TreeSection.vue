<template>
    <div class="d-flex align-items-start">
        <a href="#" data-bs-toggle="collapse" :data-bs-target="`#tree-item-${collapseKey}`" class="btn btn-sm border-0 px-0" :class="{'collapsed': collapsed}" @click="collapsed = !collapsed">
            <i :class="`fas fa-chevron-${collapsed ? 'right' : 'down'}`"></i>
        </a>
        <div class="w-100">
            <div class="d-flex align-items-center tree-node">
                <a href="#" class="btn btn-sm w-100 border-0 text-start" @click.prevent="$emit('activate', block)">{{ block.title }}</a>
                <button class="btn border-0 btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu py-0">
                    <li><a class="dropdown-item small px-2" href="#" @click.prevent="addBlock({type:'section', title: 'Section'})">Add section</a></li>
                    <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#add-primitive-${collapseKey}`">Add primitive</a></li>
                    <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#add-preset-${collapseKey}`">Add preset</a></li>
                    <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#delete-modal-${collapseKey}`">Delete</a></li>
                </ul>
                <AddPrimitive @addBlock="addBlock" :modalKey="`add-primitive-${collapseKey}`"></AddPrimitive>
                <AddPreset @addPreset="addPreset" :modalKey="`add-preset-${collapseKey}`"></AddPreset>
                <DeleteModal @remove="$emit('remove')" :modalKey="`delete-modal-${collapseKey}`" :block="block"></DeleteModal>
            </div>
            <div class="collapse" :class="{'show': !collapsed}" :id="`tree-item-${collapseKey}`">
                <tree-item v-for="(childBlock, childBlockIndex) in (block.blocks || [])" :block="childBlock" :key="childBlock.id" :depth="depth + 1" :order="childBlockIndex" @activate="activate" @remove="block.blocks.splice(childBlockIndex, 1)"></tree-item>
            </div>
        </div>
    </div>
</template>

<script>
import AddPrimitive from "./AddPrimitive.vue";
import AddPreset from "./AddPreset.vue";
import DeleteModal from "./DeleteModal.vue";
export default {
    name: "TreeSection",
    components: {AddPrimitive, AddPreset, DeleteModal},
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
    data() {
        return {
            collapsed: true
        }
    },
    computed: {
        collapseKey: function () {
            return this.depth * 10 + this.order
        }
    },
    methods: {
        addBlock: function (block) {
            this.postJson(`/api/admin/blocks`, {
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
            this.postJson(`/api/admin/presets/${preset.id}/apply`, {
                attachable_type: this.block.class_name,
                attachable_id: this.block.id,
            }, json => {
                this.block.blocks = this.block.blocks?.concat(json.data)
            })
        },
        activate: function (block) {
            this.$emit('activate', block)
        }
    },
    mounted() {
        this.collapsed = this.depth > 3
    }
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
