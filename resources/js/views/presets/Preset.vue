<template>
    <div class="row" v-if="preset.id">
        <div class="col p-4">
            <div class="mb-5">
                <input type="text" class="form-control form-control-lg" v-model="preset.title" placeholder="Page title">
            </div>
            <h4 class="mb-3">Preset structure</h4>
            <div class="border p-4 bg-white mb-5">
                <preset-section :editable="preset" v-if="preset.id"></preset-section>
            </div>
        </div>
        <div class="col-auto p-0">
            <div class="border-start p-4 bg-white sticky-top min-vh-100">
                <div class="mb-4">
                    <b>Last update:</b> {{ (new Date(preset.updated_at)).toLocaleDateString() }}
                </div>
                <button type="button" class="btn btn-success w-100" @click="save()">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="saving"></span>
                    Save
                </button>
            </div>
        </div>
    </div>
    <div class="text-center" v-else>
        <div class="spinner-grow text-secondary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "Preset",
    props: ['id'],
    data() {
        return {
            preset: {},
            saving: false
        }
    },
    methods: {
        save: function () {
            this.saving = true
            this.postJson(`/api/admin/presets/${this.id}`, this.preset, json => {
                    this.preset = json.data
                    this.saving = false
                })
        }
    },
    mounted() {
        this.getJson(`/api/admin/presets/${this.id}`, json => this.preset = json.data)
    }
}
</script>
