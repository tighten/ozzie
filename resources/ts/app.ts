import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { DateTime } from 'luxon';
import route from 'ziggy-js';

createInertiaApp({
    progress: {
        color: '#ffaa30',
        includeCSS: true,
        showSpinner: true,
    },
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        ),
    setup({ el, App, props, plugin }) {
        const ozzie = createApp({ render: () => h(App, props) });
        ozzie.config.globalProperties.$luxon = DateTime;
        ozzie.config.globalProperties.$route = route;
        ozzie.component('InertiaHead', Head);
        ozzie.component('InertiaLink', Link);
        ozzie.use(plugin);
        ozzie.mount(el);
    },
});
