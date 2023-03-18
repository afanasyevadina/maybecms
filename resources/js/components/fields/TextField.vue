<template>
    <div class="mb-4">
        <textarea v-model="field.value" class="form-control" :placeholder="field.title"></textarea>
    </div>
</template>

<script>
export default {
    name: "TextField",
    props: {
        field: {
            type: Object
        }
    }
}
</script>
