require('./bootstrap');

window.Vue = require('vue');

Vue.component('homepage-component', require('./components/HomepageComponent.vue').default);

const app = new Vue({
    el: '#app',
});
