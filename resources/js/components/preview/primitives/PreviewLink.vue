<template>
    <a :href="block.content?.link" :class="block.content?.class">
        <img :src="block.attachment?.path" alt="" v-if="block.attachment">
        {{ block.content?.text || block.title }}
    </a>
</template>

<script>
export default {
    name: "PreviewLink",
    props: {
        block: {
            type: Object
        }
    }
}
</script>
