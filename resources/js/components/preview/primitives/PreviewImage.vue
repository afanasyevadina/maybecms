<template>
    <div :class="block.content?.wrapperClass">
        <img :class="block.content?.class" :src="block.attachment?.file?.path" :alt="block.content?.alt" width="300" v-if="block.attachment?.file?.path">
        <div v-else class="p-5 border rounded-4 text-center text-muted">No image selected</div>
    </div>
</template>

<script>
export default {
    name: "PreviewImage",
    props: {
        block: {
            type: Object
        }
    }
}
</script>
