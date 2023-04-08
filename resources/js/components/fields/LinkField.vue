<template>
    <div class="mb-4">
        <input type="url" v-model="field.value" class="form-control" :placeholder="field.title" :disabled="field.source">
    </div>
    <div class="mb-4" v-if="sources.length">
        <label>Источник</label>
        <select v-model="field.source" class="form-control">
            <option :value="null">-</option>
            <option :value="sourceItem.slug" v-for="sourceItem in sources" :key="sourceItem.slug">{{ sourceItem.title }}</option>
        </select>
    </div>
</template>

<script>
export default {
    name: "LinkField",
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
            if (!this.postType) return []
            return (this.postType?.structure?.fields || [])
                .filter(item => item.type === 'link')
                .map(item => ({...item, slug: `field.${item.slug}`}))
                .concat([{slug: 'link', 'title': 'Основная ссылка'}])
        }
    }
}
</script>
