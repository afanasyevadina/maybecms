<template>
    <div :class="block.content?.wrapperClass">
        <video v-if="block.attachment?.file?.path" :src="block.attachment?.file?.path" alt="" :poster="block.attachment?.poster?.file?.path" :class="block.content?.class" controls preload="auto" width="300"></video>
    </div>
</template>

<script>
export default {
    name: "PreviewVideo",
    props: {
        block: {
            type: Object
        }
    }
}
</script>
