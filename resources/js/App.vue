<template>
    <div class="bg-light">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top" v-if="!$route.meta?.hideNav">
            <div class="container-fluid px-4">
                <router-link class="navbar-brand" to="/pages">
                    CMS maybe
                </router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent" v-if="user">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <router-link to="/pages" class="nav-link">Pages</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/presets" class="nav-link">Presets</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/post-types" class="nav-link">Post types</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/media/images" class="nav-link">Media</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/settings" class="nav-link">Settings</router-link>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ user.name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#" @click.prevent="logout">
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            <router-view :key="$route.path"></router-view>
        </main>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            user: null,
            postTypes: [],
            loading: true
        }
    },
    methods: {
        logout: function () {
            fetch(`/api/admin/logout`, {
                method: 'POST'
            })
                .then(() => {
                    this.$root.$data.user = null
                    localStorage.removeItem('_cms_user')
                    this.$router.push('/login')
                })
        },
        loadModels: function () {
            this.getJson(`/api/admin/post-types`, json => {
                this.postTypes = json.data
                this.loading = false
            })
        }
    },
    mounted() {
        if (localStorage.getItem('_cms_user')) {
            this.user = JSON.parse(localStorage.getItem('_cms_user'))
            this.loadModels()
        }
    }
}
</script>

<style>
.dropdown-toggle::after {
    display: none;
}
.preview-img {
    aspect-ratio: 16 / 9;
    object-fit: contain;
}
.c-pointer {
    cursor: pointer;
}
</style>
