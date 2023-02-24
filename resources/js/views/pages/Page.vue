<template>
    <div class="vh-100 editor-page bg-white" v-if="page.id">
        <div class="px-3 d-flex justify-content-between align-items-center border-bottom">
            <router-link to="/pages" class="btn btn-sm btn-light">
                <i class="fas fa-chevron-left"></i>
                Back to pages
            </router-link>
            <button type="button" class="btn btn-sm btn-success" @click="save()">
                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-if="saving"></span>
                Save
            </button>
        </div>
        <div class="editor-wrapper">
            <div class="editor-tree border-end overflow-auto p-3">
                <tree-section :block="page" :depth="0" :order="0" @activate="activate"></tree-section>
            </div>
            <div class="editor-preview overflow-auto p-3">
                <preview-section :block="page"></preview-section>
            </div>
            <div class="editor-fields p-3 border-top overflow-auto">
                <template v-if="activeElement">
                    <field :block="activeElement" @save="loadPage"
                           @remove="activeElement = null; loadPage()"></field>
                </template>
                <template v-else>
                    <div class="mb-4">
                        <label>Page title</label>
                        <input type="text" class="form-control" v-model="page.title" placeholder="Page title">
                    </div>
                    <div class="mb-4">
                        <label>
                            <input type="checkbox" v-model="page.active">
                            Active
                        </label>
                    </div>
                    <MetaFields :meta="page.meta"></MetaFields>
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
import MetaFields from "../../components/MetaFields.vue";

export default {
    name: "Page",
    props: ['id'],
    components: {MetaFields},
    data() {
        return {
            page: {},
            activeElement: null,
            saving: false
        }
    },
    methods: {
        loadPage: function () {
            this.page = {}
            this.getJson(`/api/admin/pages/${this.id}`, json => this.page = json.data)
        },
        save: function () {
            this.saving = true
            this.postJson(`/api/admin/pages/${this.id}`, this.page, json => {
                this.page = json.data
                this.saving = false
            })
        },
        activate: function (block) {
            this.activeElement = block.type ? block : null
        }
    },
    mounted() {
        this.loadPage()
    }
}
</script>
<style scoped>
.editor-page {
    display: grid;
    grid-template-rows: 42px calc(100vh - 42px);
}
.editor-wrapper {
    display: grid;
    grid-template-rows: 50% 50%;
    grid-template-columns: 200px 1fr;
}
.editor-tree {
    grid-row: 1 / 3;
}
</style>
