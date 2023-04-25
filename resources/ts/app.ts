import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { DateTime } from 'luxon';
import route from 'ziggy-js';

createInertiaApp(
    {
        progress: {
            color: '#ffaa30',
            includeCSS: true,
            showSpinner: true,
        },
        resolve: (name) => import(`./Pages/${name}`),
        setup({
            el, App, props, plugin,
        }) {
            const ozzie = createApp({ render: () => h(App, props) });
            ozzie.config.globalProperties.$luxon = DateTime;
            ozzie.config.globalProperties.$route = route;
            ozzie.component('InertiaHead', Head);
            ozzie.component('InertiaLink', Link);
            ozzie.use(plugin);
            ozzie.mount(el);
        },
    },
);
