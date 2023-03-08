<template>
    <div :class="block.content?.class" v-if="isSection">
        <preview-item v-for="childBlock in (block.blocks || [])" :block="childBlock" :key="childBlock.id"></preview-item>
    </div>
    <component :is="`preview-${block.type}`" :block="block" v-else></component>
</template>

<script>
export default {
    name: "PreviewItem",
    props: {
        block: {
            type: Object
        }
    },
    computed: {
        isSection: function () {
            return this.block.type === 'section' || !this.block.type
        }
    }
}
</script>
