import Vue from 'vue'
import { InertiaProgress } from '@inertiajs/progress'
import { App, plugin } from '@inertiajs/inertia-vue'
import VModal from 'vue-js-modal';
import { DateTime } from "luxon";

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

InertiaProgress.init({
    delay: 250,
    color: '#29d',
    includeCSS: true,
    showSpinner: false,
})

Vue.prototype.$luxon = DateTime;
Vue.prototype.$route = (...args) => route(...args).url()

Vue.use(plugin)
Vue.use(VModal);

window.Vue = require('vue');
Vue.component('modal-button', require('./components/ModalButton.vue').default);

const el = document.getElementById('app')

new Vue({
    render: h => h(App, {
        props: {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: name => import(`./Pages/${name}`).then(module => module.default),
        },
    }),
}).$mount(el)
