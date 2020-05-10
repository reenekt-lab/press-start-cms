require('./bootstrap');

// Font Awesome
require('@fortawesome/fontawesome-free/js/all');

//Подключение кода vue
window.Vue = require('vue');

Vue.component('example', require('./components/ExampleComponent.vue').default)
Vue.component('post-editor', require('./components/PostEditor.vue').default);
Vue.component('post-component', require('./components/PostComponent.vue').default);

new Vue({
    el:'.qwerty'
});
