<template>
    <div class="modal fade" tabindex="-1" :id="modalKey">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Выбрать шаблон</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <template v-if="presets.length">
                        <div class="row">
                            <div class="col-4 mb-3" v-for="preset in presets" :key="preset.id">
                                <a href="#" class="btn btn-outline-dark w-100 h-100" data-bs-dismiss="modal"
                                   @click.prevent="$emit('addPreset', preset)">{{ preset.title }}</a>
                            </div>
                        </div>
                    </template>
                    <div class="text-center text-muted" v-else>
                        No presets yet.<br>
                        <router-link :to="{name: 'Presets'}" target="_blank">Manage presets</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TreeAddPresetModal",
    props: {
        modalKey: {
            type: String
        }
    },
    data() {
        return {
            presets: []
        }
    },
    mounted() {
        this.getJson(`/api/presets`, json => this.presets = json.data)
    }
}
</script>
