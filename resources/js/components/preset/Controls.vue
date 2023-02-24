<template>
    <div class="d-flex flex-wrap">
        <button type="button" class="btn btn-outline-dark me-3" @click="$emit('addBlock', {type:'section', title: 'Section'})">
            Add block
        </button>
        <div class="dropdown me-3">
            <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Add primitive
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" @click.prevent="$emit('addBlock', primitive)" v-for="primitive in primitives" :key="primitive.id">{{ primitive.title}}</a></li>
            </ul>
        </div>
        <div class="dropdown me-3" v-if="presets.length">
            <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Choose preset
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" @click.prevent="$emit('addPreset', preset)" v-for="preset in presets" :key="preset.id">{{ preset.title}}</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "Controls",
    data() {
        return {
            primitives: [],
            presets: [],
        }
    },
    mounted() {
        this.getJson(`/api/admin/primitives`, json => this.primitives = json.data)
        this.getJson(`/api/admin/presets`, json => this.presets = json.data)
    }
}
</script>
