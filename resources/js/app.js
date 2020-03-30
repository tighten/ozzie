require('./bootstrap');

window.Vue = require('vue');

import VModal from 'vue-js-modal'

Vue.use(VModal);
Vue.component('modal-button', require('./components/ModalButton.vue').default);

const app = new Vue({
    el: '#app',
});
