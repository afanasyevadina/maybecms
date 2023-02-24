<template>
    <div :class="block.content?.class">
        <preview-item v-for="childBlock in (block.blocks || [])" :block="childBlock" :key="childBlock.id"></preview-item>
    </div>
</template>

<script>
export default {
    name: "PreviewSection",
    props: {
        block: {
            type: Object
        }
    }
}
</script>
