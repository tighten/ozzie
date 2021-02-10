/* eslint-disable import/no-dynamic-require */
import { createApp, h } from 'vue';
import { App, plugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { DateTime } from 'luxon';
import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

InertiaProgress.init({
    color: '#ffaa30',
    includeCSS: true,
    showSpinner: true,
});

const el = document.getElementById('app') as HTMLDivElement;

const app = createApp({
    render: () => h(App, {
        initialPage: JSON.parse(<string>el.dataset.page),
        resolveComponent: (name: string) => import(`./Pages/${name}`).then((module) => module.default),
    }),
});
app.config.globalProperties.$luxon = DateTime;
app.config.globalProperties.$http = axios;
app.use(plugin).mount(el);
