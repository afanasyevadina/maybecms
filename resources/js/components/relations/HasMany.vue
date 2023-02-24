<template>
    <div class="mb-4">
        <div class="mb-4">{{ relation.title }}</div>
        <div class="mb-3" v-for="option in options" :key="option.id">
            <label>
                <input type="checkbox" v-model="relation.related_posts" :value="option.id">
                {{ option.title }}
            </label>
        </div>
    </div>
</template>

<script>
export default {
    name: "HasOne",
    props: {
        relation: {
            type: Object
        }
    },
    data() {
        return {
            options: []
        }
    },
    mounted() {
        this.getJson(`/api/admin/${this.relation.related_model?.plural_slug}`,json => this.options = json.data)
    }
}
</script>
