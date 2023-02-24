<template>
    <div class="mb-4">
        <label>{{ relation.title }}</label>
        <select class="form-control" v-model="relation.related_post">
            <option :value="null">-</option>
            <option :value="option.id" v-for="option in options" :key="option.id">{{ option.title }}</option>
        </select>
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
