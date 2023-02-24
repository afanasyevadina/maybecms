<template>
    <component :is="`preview-${block.type}`" :block="block"></component>
</template>

<script>
export default {
    name: "PreviewPrimitive",
    props: {
        block: {
            type: Object
        }
    }
}
</script>
