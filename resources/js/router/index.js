import {createRouter, createWebHistory} from "vue-router";
import Pages from "../views/pages/Pages.vue";
import Page from "../views/pages/Page.vue";
import PostTypes from "../views/post-types/PostTypes.vue";
import PostType from "../views/post-types/PostType.vue";
import Presets from "../views/presets/Presets.vue";
import Preset from "../views/presets/Preset.vue";
import Posts from "../views/posts/Posts.vue";
import Post from "../views/posts/Post.vue";
import Settings from "../views/settings/Settings.vue";
import Images from "../views/media/Images.vue";
import Video from "../views/media/Video.vue";
import Files from "../views/media/Files.vue";
import Login from "../views/Login.vue";
import NotFound from "../views/404.vue";
import Admin from "../views/Admin.vue";

import SitePage from "../views/site/Page.vue";
import SiteHome from "../views/site/Home.vue";

const routes = [{
    path: '/admin',
    component: Admin,
    children: [{
        path: '',
        redirect: {name: 'Pages'}
    }, {
        path: 'login',
        component: Login,
        name: 'Login'
    }, {
        path: 'pages',
        component: Pages,
        name: 'Pages'
    }, {
        path: 'pages/:id',
        component: Page,
        name: 'Page',
        props: true,
        meta: {
            hideNav: true
        }
    }, {
        path: 'post-types',
        component: PostTypes,
        name: 'PostTypes'
    }, {
        path: 'post-types/:id',
        component: PostType,
        name: 'PostType',
        props: true
    }, {
        path: 'presets',
        component: Presets,
        name: 'Presets'
    }, {
        path: 'presets/:id',
        component: Preset,
        name: 'Preset',
        props: true
    }, {
        path: 'posts/:postType',
        component: Posts,
        name: 'Posts',
        props: true
    }, {
        path: 'posts/:postType/:id',
        component: Post,
        name: 'Post',
        props: true
    }, {
        path: 'settings',
        component: Settings,
        name: 'Settings'
    }, {
        path: 'media/images',
        component: Images,
        name: 'Images'
    }, {
        path: 'media/video',
        component: Video,
        name: 'Video'
    }, {
        path: 'media/files',
        component: Files,
        name: 'Files'
    }]
}, {
    path: '/:id',
    component: SitePage,
    name: 'SitePage',
    props: true
}, {
    path: '/',
    component: SiteHome,
    name: 'SiteHome'
}, {
    path: '/404',
    component: NotFound,
    name: 'NotFound'
}]

const router = new createRouter({
    routes,
    history: createWebHistory('/')
})

router.beforeEach((to, from, next) => {
    if (to.path.startsWith('/admin/') && to.name !== 'Login' && !localStorage.getItem('_cms_user')) next({ name: 'Login' })
    else next()
})

export default router
