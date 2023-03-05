<template>
    <div class="d-flex align-items-start">
        <a href="#" data-bs-toggle="collapse" :data-bs-target="`#tree-item-${collapseKey}`" class="btn btn-sm border-0 px-0" :class="{'collapsed': collapsed}" @click="collapsed = !collapsed">
            <i :class="`fas fa-chevron-${collapsed ? 'right' : 'down'}`"></i>
        </a>
        <div class="w-100">
            <div class="d-flex align-items-center tree-node">
                <a href="#" class="btn btn-sm w-100 border-0 text-start" @click.prevent="$emit('activate', block)">{{ block.title }}</a>
                <tree-dropdown :block="block" :depth="depth" :order="order" :count="count" @update="$emit('update')"></tree-dropdown>
            </div>
            <div class="collapse" :class="{'show': !collapsed}" :id="`tree-item-${collapseKey}`">
                <tree-item v-for="(childBlock, childBlockIndex) in (block.blocks || []).sort((a, b) => a.order - b.order)" :block="childBlock" :key="childBlock.id" :depth="depth + 1" :order="childBlockIndex" :count="block.blocks.length" @activate="activate" @moveUp="moveUp(childBlockIndex)" @moveDown="moveDown(childBlockIndex)" @update="$emit('update')"></tree-item>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TreeSection",
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
        }
    },
    methods: {
        activate: function (block) {
            this.$emit('activate', block)
        },
        moveUp: function (blockIndex) {
            this.block.blocks[blockIndex].order--
            this.block.blocks[blockIndex - 1].order++
        },
        moveDown: function (blockIndex) {
            this.block.blocks[blockIndex].order++
            this.block.blocks[blockIndex + 1].order--
        }
    },
    mounted() {
        this.collapsed = this.depth > 3
    }
}
</script>
