<template>
    <div class="p-4">
        <div>
            <div class="d-flex mb-4 justify-content-between align-items-center">
                <h1>Все страницы</h1>
                <a href="#" data-bs-toggle="modal" data-bs-target="#add-page" class="btn btn-success" v-if="pages.data.length">Добавить еще одну</a>
            </div>
            <div class="text-center" v-if="loading">
                <div class="spinner-grow text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <template v-else>
                <table class="table table-striped mb-4">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th>Автор</th>
                        <th>Последнее обновление</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="page in pages.data" :key="page.id">
                        <tr>
                            <td>{{ page.id }}</td>
                            <td>{{ page.title }}</td>
                            <td>{{ page.user.name }}</td>
                            <td>{{ formatDate(page.updated_at) }}</td>
                            <td class="text-end text-nowrap">
                                <router-link :to="{name: 'SitePage', params: {id: page.slug}}" class="btn btn-light me-2" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </router-link>
                                <router-link :to="{name: 'Page', params: {id: page.id}}" class="btn btn-light me-2">
                                    <i class="fas fa-pen"></i>
                                </router-link>
                                <a href="#" class="btn btn-light" data-bs-toggle="modal" :data-bs-target="`#delete-page-${page.id}`">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <DeletePage :id="page.id"></DeletePage>
                    </template>
                    <tr v-if="!pages.data.length">
                        <td colspan="5" class="text-center py-3">
                            Пока нет страниц
                            <br>
                            <br>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-page" class="btn btn-outline-dark">Создать первую страницу</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </div>
        <CreatePage></CreatePage>
    </div>
</template>

<script>
import CreatePage from "./CreatePage.vue";
import DeletePage from "./DeletePage.vue";
export default {
    name: 'Pages',
    components: {
        CreatePage,
        DeletePage
    },
    data() {
        return {
            pages: {
                data: []
            },
            loading: true
        }
    },
    mounted() {
        this.getJson(`/api/pages`,json => {
                this.pages = json
                this.loading = false
            })
    }
}
</script>
