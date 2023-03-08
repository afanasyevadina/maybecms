/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import {createApp} from 'vue';
import router from './router'
import store from './store'

import App from "./App.vue";

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

window.app = createApp(App);

app.use(router)
app.use(store)

import HasOne from "./components/relations/HasOne.vue";
import HasMany from "./components/relations/HasMany.vue";

import Field from './components/fields/Field.vue';
import TextField from './components/fields/TextField.vue';
import MarkdownField from "./components/fields/MarkdownField.vue";
import LinkField from "./components/fields/LinkField.vue";
import ImageField from "./components/fields/ImageField.vue";
import VideoField from "./components/fields/VideoField.vue";

import PreviewText from './components/preview/primitives/PreviewText.vue';
import PreviewMarkdown from "./components/preview/primitives/PreviewMarkdown.vue";
import PreviewLink from "./components/preview/primitives/PreviewLink.vue";
import PreviewImage from "./components/preview/primitives/PreviewImage.vue";
import PreviewVideo from "./components/preview/primitives/PreviewVideo.vue";

import TreeItem from "./components/tree/TreeItem.vue";

import PreviewItem from "./components/preview/PreviewItem.vue";

import AddControls from "./components/AddControls.vue";

app.component('field', Field);
app.component('text-field', TextField);
app.component('markdown-field', MarkdownField);
app.component('link-field', LinkField);
app.component('image-field', ImageField);
app.component('video-field', VideoField);

app.component('preview-text', PreviewText);
app.component('preview-markdown', PreviewMarkdown);
app.component('preview-link', PreviewLink);
app.component('preview-image', PreviewImage);
app.component('preview-video', PreviewVideo);

app.component('has-one', HasOne);
app.component('has-many', HasMany);

app.component('tree-item', TreeItem);

app.component('preview-item', PreviewItem);

app.component('add-controls', AddControls);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.globEager('./**/*.vue')).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
import http from './mixins/http.js'
import str from './mixins/str.js'
import media from './mixins/media.js'
import util from './mixins/util.js'

app.mixin(http)
app.mixin(str)
app.mixin(media)
app.mixin(util)

app.mount('#app');
