<template>
    <img :class="block.content?.class" :srcset="`${block.attachment?.path || ''}, https://www.etalon-holding.kz/images/not-found.png`" alt="">
</template>

<script>
export default {
    name: "Image",
    props: {
        block: {
            type: Object
        }
    }
}
</script>
