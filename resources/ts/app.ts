/* eslint-disable @typescript-eslint/ban-ts-comment */
import { createApp, h } from 'vue';
// @ts-ignore
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { DateTime } from 'luxon';
import axios from 'axios';
import route from 'ziggy-js';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

InertiaProgress.init({
    color: '#ffaa30',
    includeCSS: true,
    showSpinner: true,
});

createInertiaApp({
    resolve: (name) => import(`./Pages/${name}`),
    setup({
        el, app, props, plugin,
    }) {
        const ozzie = createApp({ render: () => h(app, props) });
        ozzie.config.globalProperties.$luxon = DateTime;
        ozzie.config.globalProperties.$http = axios;
        ozzie.config.globalProperties.$route = route;
        ozzie.use(plugin);
        ozzie.mount(el);
    },
});
