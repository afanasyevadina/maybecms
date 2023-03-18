<template>
    <div class="mb-4">
        <div class="mb-4">
            <input type="text" v-model="(block.content || {}).text" class="form-control" placeholder="Текст ссылки">
        </div>
        <div class="mb-4">
            <input type="url" v-model="(block.content || {}).link" class="form-control" placeholder="Link URL">
        </div>
    </div>
</template>

<script>
export default {
    name: "LinkField",
    props: {
        block: {
            type: Object
        }
    }
}
</script>
