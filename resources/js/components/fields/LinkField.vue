<template>
    <div class="mb-4">
        <input type="url" v-model="field.value" class="form-control" :placeholder="field.title">
    </div>
</template>

<script>
export default {
    name: "LinkField",
    props: {
        field: {
            type: Object
        }
    }
}
</script>
