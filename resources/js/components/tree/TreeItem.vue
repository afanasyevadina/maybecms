<template>
    <tree-section :block="block" :depth="depth" :order="order" v-if="block.type === 'section'" @activate="activate" @remove="$emit('remove')"></tree-section>
    <tree-primitive v-else :block="block" :depth="depth" :order="order" @activate="activate" @remove="$emit('remove')"></tree-primitive>
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
        }
    },
    methods: {
        activate: function (block) {
            this.$emit('activate', block)
        }
    }
}
</script>
