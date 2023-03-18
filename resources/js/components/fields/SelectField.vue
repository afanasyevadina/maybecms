<template>
    <div class="mb-4">
        <select v-model="field.value" class="form-control">
            <option v-for="(option, optionKey) in field.options" :value="optionKey" :key="optionKey">{{ option }}</option>
        </select>
    </div>
</template>

<script>
export default {
    name: "SelectField",
    props: {
        field: {
            type: Object
        }
    }
}
</script>
