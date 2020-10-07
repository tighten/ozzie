require('./bootstrap');

window.Vue = require('vue');

import VModal from 'vue-js-modal';

Vue.use(VModal);
Vue.component('modal-button', require('./components/ModalButton.vue').default);
Vue.component('pr-modal', require('./components/PrModal.vue').default);

const app = new Vue({
    el: '#app',
});
