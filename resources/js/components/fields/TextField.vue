<template>
    <div class="mb-4">
        <textarea v-model="(block.content || {}).text" class="form-control" :readonly="readonly" placeholder="Text"></textarea>
    </div>
</template>

<script>
export default {
    name: "TextField",
    props: {
        block: {
            type: Object
        },
        readonly: {
            type: Boolean,
            default: false
        }
    }
}
</script>
