<template>
    <div class="vh-100 editor-page bg-white" v-if="preset.id">
        <div class="px-3 d-flex justify-content-between align-items-center border-bottom">
            <router-link :to="{name: 'Presets'}" class="btn btn-sm btn-light">
                <i class="fas fa-chevron-left"></i>
                Назад
            </router-link>
            <button type="button" class="btn btn-sm btn-success" @click="save()">
                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="saving"></span>
                Сохранить
            </button>
        </div>
        <div class="editor-wrapper">
            <div class="editor-tree border-end overflow-auto p-3">
                <tree-item :block="preset" :depth="0" :order="0" :count="preset.blocks.length"></tree-item>
            </div>
            <div class="editor-preview overflow-auto p-3">
                <preview-item :block="preset"></preview-item>
            </div>
            <div class="editor-fields p-3 border-top overflow-auto">
                <template v-if="activeElement">
                    <field :block="activeElement" @save="loadPreset"
                           @remove="activeElement = null; loadPreset()"></field>
                </template>
                <template v-else>
                    <div class="mb-4">
                        <label>Название</label>
                        <input type="text" class="form-control" v-model="preset.title">
                    </div>
                </template>
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
import {mapState} from "vuex";

export default {
    name: "Preset",
    props: ['id'],
    data() {
        return {
            preset: {},
            saving: false
        }
    },
    computed: {
        ...mapState([
            'activeElement'
        ])
    },
    methods: {
        loadPreset: function () {
            this.preset = {}
            this.getJson(`/api/presets/${this.id}`, json => this.preset = json.data)
        },
        save: function () {
            this.saving = true
            this.postJson(`/api/presets/${this.id}`, this.preset, json => {
                    this.preset = json.data
                    this.saving = false
                })
        }
    },
    mounted() {
        this.loadPreset()
    }
}
</script>
