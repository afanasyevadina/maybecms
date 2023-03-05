<template>
    <div class="d-flex align-items-center tree-node">
        <a href="#" class="py-1 btn btn-sm w-100 text-start border-0" @click.prevent="$emit('activate', block)">{{ block.title }}</a>
        <tree-dropdown :block="block" :depth="depth" :order="order" :count="count" @update="$emit('update')"></tree-dropdown>
    </div>
</template>

<script>
export default {
    name: "TreePrimitive",
    props: {
        block: {
            type: Object
        },
        depth: {
            type: Number
        },
        order: {
            type: Number
        },
        count: {
            type: Number
        }
    }
}
</script>
<style scoped>
.tree-node:not(:hover) .dropdown-toggle {
    display: none;
}
.tree-node:hover {
    background-color: #f8f9fa;
}
</style>
