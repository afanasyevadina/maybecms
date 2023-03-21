<template>
    <div class="mb-4">
        <textarea v-model="field.value" class="form-control" :placeholder="field.title" :disabled="field.source"></textarea>
    </div>
    <div class="mb-4" v-if="postType">
        <label>Источник</label>
        <select v-model="field.source" class="form-control">
            <option :value="null">-</option>
            <option :value="sourceItem.slug" v-for="sourceItem in sources" :key="sourceItem.slug">{{ sourceItem.title }}</option>
        </select>
    </div>
</template>

<script>
export default {
    name: "TextField",
    props: {
        field: {
            type: Object
        },
        postType: {
            type: Object,
            default: null
        }
    },
    computed: {
        sources: function () {
            return (this.postType?.structure?.fields || [])
                .filter(item => item.type === 'text')
                .map(item => ({...item, slug: `field.${item.slug}`}))
                .concat([{slug: 'title', 'title': 'Название'}])
        }
    }
}
</script>
