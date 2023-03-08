<template>
    <div class="d-flex align-items-start">
        <a href="#" data-bs-toggle="collapse" :data-bs-target="`#tree-item-${collapseKey}`" class="btn btn-sm border-0 px-0" :class="{'collapsed': collapsed}" @click="collapsed = !collapsed" v-if="isSection">
            <i :class="`fas fa-chevron-${collapsed ? 'right' : 'down'}`"></i>
        </a>
        <div class="w-100">
            <div class="d-flex align-items-center tree-node">
                <a href="#" class="btn btn-sm w-100 border-0 text-start" @click.prevent="activate">{{ block.title }}</a>
                <button class="btn border-0 btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu py-0">
                    <template v-if="isSection">
                        <li><a class="dropdown-item small px-2" href="#" @click.prevent="addBlock({type:'section', title: 'Section'})">Add section</a></li>
                        <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#add-primitive-${collapseKey}`">Add primitive</a></li>
                        <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#add-preset-${collapseKey}`">Add preset</a></li>
                    </template>
                    <li><a class="dropdown-item small px-2" href="#" @click.prevent="cloneBlock">Clone</a></li>
                    <li><a class="dropdown-item small px-2" href="#" @click.prevent="$emit('moveUp')" v-if="block.order > 1">Move up</a></li>
                    <li><a class="dropdown-item small px-2" href="#" @click.prevent="$emit('moveDown')" v-if="block.order < count">Move down</a></li>
                    <li><a class="dropdown-item small px-2" href="#" data-bs-toggle="modal" :data-bs-target="`#delete-modal-${collapseKey}`">Delete</a></li>
                </ul>
            </div>
            <div class="collapse" :class="{'show': !collapsed}" :id="`tree-item-${collapseKey}`">
                <tree-item v-for="(childBlock, childBlockIndex) in (block.blocks || []).sort((a, b) => a.order - b.order)" :block="childBlock" :key="childBlock.id" :depth="depth + 1" :order="childBlockIndex" :count="block.blocks.length"
                           @moveUp="moveUp(childBlockIndex)" @moveDown="moveDown(childBlockIndex)" @update="$emit('update')"></tree-item>
            </div>
        </div>
        <TreeDeleteModal @update="$emit('update')" :modalKey="`delete-modal-${collapseKey}`" :block="block"></TreeDeleteModal>
        <TreeAddPrimitiveModal @addBlock="addBlock" :modalKey="`add-primitive-${collapseKey}`"></TreeAddPrimitiveModal>
        <TreeAddPresetModal @addPreset="addPreset" :modalKey="`add-preset-${collapseKey}`"></TreeAddPresetModal>
    </div>
</template>

<script>
import TreeDeleteModal from "./TreeDeleteModal.vue";
import TreeAddPrimitiveModal from "./TreeAddPrimitiveModal.vue";
import TreeAddPresetModal from "./TreeAddPresetModal.vue";
import {mapMutations} from "vuex";

export default {
    name: "TreeItem",
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
    data() {
        return {
            collapsed: true
        }
    },
    computed: {
        collapseKey: function () {
            return this.depth * 10 + this.order
        },
        isSection: function () {
            return this.block.type === 'section' || !this.block.type
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
                this.setActiveElement(json.data)
            })
        },
        addPreset: function (preset) {
            this.postJson(`/api/presets/${preset.id}/apply`, {
                attachable_type: this.block.class_name,
                attachable_id: this.block.id,
            }, json => {
                this.block.blocks = this.block.blocks?.concat(json.data)
            })
        },
        activate: function () {
            this.setActiveElement(this.block.type ? this.block : null)
        },
        moveUp: function (blockIndex) {
            this.block.blocks[blockIndex].order--
            this.block.blocks[blockIndex - 1].order++
        },
        moveDown: function (blockIndex) {
            this.block.blocks[blockIndex].order++
            this.block.blocks[blockIndex + 1].order--
        },
        ...mapMutations([
            'setActiveElement'
        ])
    },
    mounted() {
        this.collapsed = this.depth > 3
    }
}
</script>
