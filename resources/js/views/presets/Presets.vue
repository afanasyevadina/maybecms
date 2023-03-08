<template>
    <div class="p-4">
        <div>
            <div class="d-flex mb-4 justify-content-between align-items-center">
                <h1>Шаблоны</h1>
                <a href="#" data-bs-toggle="modal" data-bs-target="#add-preset" class="btn btn-success" v-if="presets.data.length">Создать еще шаблон</a>
            </div>
            <div class="text-center" v-if="loading">
                <div class="spinner-grow text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <template v-else>
                <table class="table table-striped mb-4">
                    <tbody v-if="!presets.data.length">
                    <tr>
                        <td colspan="5" class="text-center py-3">
                            Пока нет шаблонов
                            <br>
                            <br>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-preset" class="btn btn-outline-dark">Создать первый шаблон</a>
                        </td>
                    </tr>
                    </tbody>
                    <template v-else>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th>Последнее обновление</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="preset in presets.data" :key="preset.id">
                            <tr>
                                <td>{{ preset.id }}</td>
                                <td>{{ preset.title }}</td>
                                <td>{{ formatDate(preset.updated_at) }}</td>
                                <td class="text-end text-nowrap">
                                    <router-link :to="{name: 'Preset', params: {id: preset.id}}" class="btn btn-light me-2">
                                        <i class="fas fa-pen"></i>
                                    </router-link>
                                    <a href="#" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-preset-${preset.id}`">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <DeletePreset :id="preset.id"></DeletePreset>
                        </template>
                        </tbody>
                    </template>
                </table>
            </template>
        </div>
        <CreatePreset></CreatePreset>
    </div>
</template>

<script>
import CreatePreset from "./CreatePreset.vue";
import DeletePreset from "./DeletePreset.vue";

export default {
    name: 'Presets',
    components: {
        CreatePreset,
        DeletePreset
    },
    data() {
        return {
            presets: {
                data: []
            },
            loading: true
        }
    },
    mounted() {
        this.getJson(`/api/presets`,json => {
            this.presets = json
            this.loading = false
        })
    }
}
</script>
