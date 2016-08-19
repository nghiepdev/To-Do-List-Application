import Vue from 'vue';
Vue.use(require('vue-resource'));
Vue.use(require('vue-async-data'));
Vue.use(require('keen-ui'));

(typeof api_token === 'undefined') || (Vue.http.headers.common['Authorization'] = `Bearer ${api_token}`);
// Vue.http.headers.common['X-CSRF-TOKEN'] = _token;

import Todos from './components/Todos/Todos.vue';

new Vue({
    el: 'body',

    components: {
        Todos
    }
});