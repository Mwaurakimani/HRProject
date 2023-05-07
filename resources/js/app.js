import './bootstrap';
import '../css/app.css';
import '../scss/index.scss'

import {createApp, h, useAttrs} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import {createPinia} from 'pinia';
import Modal from "./Components/Modal.vue";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const piniaPlugin = createPinia();

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        let authUser = null

        if (props.initialPage.props.auth && props.initialPage.props.auth.user) {
            authUser = props.initialPage.props.auth.user;
        }


        return createApp({render: () => h(App, props)})
            .provide('currentUser',authUser)
            .use(plugin)
            .use(piniaPlugin)
            .use(ZiggyVue, Ziggy)
            .mount(el);

    },
    progress: {
        color: '#4B5563',
    },
});
