<template>
    <div>
        <div class="mb-4">
            <label>Block title</label>
            <input type="text" v-model="block.title" required class="form-control">
        </div>
        <component v-if="block.type !== 'section'" :is="`${block.type}-field`" :block="block"></component>
        <div class="mb-4">
            <label>Class</label>
            <input type="text" v-model="(block.content || {}).class" class="form-control">
        </div>
    </div>
</template>

<script>
export default {
    name: "BaseField",
    props: {
        block: {
            type: Object
        }
    },
    data() {
        return {
            saving: false,
            deleting: false
        }
    }
}
</script>
