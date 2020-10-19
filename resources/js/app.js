import Vue from 'vue';
import { App, plugin } from '@inertiajs/inertia-vue';
import { InertiaProgress } from '@inertiajs/progress';
import { DateTime } from 'luxon';

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

InertiaProgress.init({
  color: '#d9dcf1',
  includeCSS: true,
  showSpinner: true,
});

Vue.prototype.$luxon = DateTime;

Vue.use(plugin);

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
