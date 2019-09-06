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

// const _ = import('lodash');
import _ from 'lodash';
// Vue.prototype.trans = string => _.get(window.i18n, string);
//
Vue.filter ('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
});

Vue.prototype.trans = (key) => {
    return _.get(window.trans, key, key);
};

Vue.component('registration-component', require('./components/Auth/RegistrationComponent').default);
Vue.component('login-component', require('./components/Auth/LoginComponent').default);
Vue.component('reset-password-email-component', require('./components/Auth/ResetPasswordEmailComponent').default);
Vue.component('reset-password-component', require('./components/Auth/ResetPasswordComponent').default);
Vue.component('footer-component', require('./components/layots/FooterComponent').default);
Vue.component('lang-component', require('./components/layots/LangComponentForMain').default);
Vue.component('avatar-component', require('./components/profile/AvatarComponent').default);
Vue.component('bio-component', require('./components/profile/BioComponent').default);
Vue.component('name-component', require('./components/profile/NameComponent').default);
Vue.component('email-component', require('./components/profile/EmailComponent').default);
Vue.component('paswword-component', require('./components/profile/PasswordComponent').default);
Vue.component('star-component', require('./components/movies/StarComponent').default);
Vue.component('search-component', require('./components/movies/SearchComponent').default);
Vue.component('actors-component', require('./components/one_movie_page/ActorsComponent').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
