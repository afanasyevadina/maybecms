<template>
    <tree-section :block="block" :depth="depth" :order="order" :count="count" v-if="block.type === 'section'" @activate="activate" @update="$emit('update')"></tree-section>
    <tree-primitive v-else :block="block" :depth="depth" :order="order" :count="count" @activate="activate" @update="$emit('update')" @moveUp="$emit('moveUp')" @moveDown="$emit('moveDown')"></tree-primitive>
</template>

<script>
export default {
    name: "TreeItem",
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
    methods: {
        activate: function (block) {
            this.$emit('activate', block)
        }
    }
}
</script>
