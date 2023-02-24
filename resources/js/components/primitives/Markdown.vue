<template>
    <div :class="block.content?.class">
        <span v-html="nl2br(block.content?.text)" v-if="block.content?.text"></span>
        <span v-else class="block-placeholder">{{ block.title }}</span>
    </div>
</template>

<script>
export default {
    name: "Markdown",
    props: {
        block: {
            type: Object
        }
    }
}
</script>
