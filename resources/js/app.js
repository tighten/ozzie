import Vue from 'vue';
import { InertiaProgress } from '@inertiajs/progress';
import { App, plugin } from '@inertiajs/inertia-vue';
import VModal from 'vue-js-modal';
import { DateTime } from 'luxon';

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

InertiaProgress.init({
    color: '#d9dcf1',
    includeCSS: true,
    showSpinner: true,
});

Vue.prototype.$luxon = DateTime;
Vue.prototype.$route = (...args) => route(...args).url();

Vue.use(plugin);
Vue.use(VModal);

window.Vue = require('vue');

const el = document.getElementById('app');

new Vue({
    render: h => h(App, {
        props: {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: name => import(`./Pages/${name}`).then(module => module.default),
        },
    }),
}).$mount(el);
