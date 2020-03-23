require('./bootstrap');

window.Vue = require('vue');

import VModal from 'vue-js-modal'

Vue.use(VModal);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
    el: '#app',
});
