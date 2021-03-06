
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('contacts-component', require('./components/ContactsComponent.vue').default);
Vue.component('contacts-list-component', require('./components/ContactsListComponent.vue').default);
Vue.component('new-contact-modal-component', require('./components/NewContactModalComponent.vue').default);
Vue.component('update-contact-modal-component', require('./components/UpdateContactModalComponent.vue').default);
Vue.component('show-contact-modal-component', require('./components/ShowContactModalComponent.vue').default);
Vue.component('delete-contact-modal-component', require('./components/DeleteContactModalComponent.vue').default);
Vue.component('delete-contacts-modal-component', require('./components/DeleteContactsModalComponent.vue').default);
Vue.component('update-user-component', require('./components/UpdateUserComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
