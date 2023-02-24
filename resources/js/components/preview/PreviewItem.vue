<template>
    <preview-section :block="block" v-if="block.type == 'section'"></preview-section>
    <preview-primitive v-else :block="block"></preview-primitive>
</template>

<script>
export default {
    name: "PreviewItem",
    props: {
        block: {
            type: Object
        }
    }
}
</script>
