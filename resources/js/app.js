/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import { DatePicker, Upload, Select, Option, Loading, Input, Notification, Checkbox, Pagination, Form, Autocomplete, Button } from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
// import numeral from "numeral";

window.Vue = require('vue').default;

// Vue.filter("numberFormat", function(value) {
//     if (!value) return "0.00";
//     return numeral(value).format("0,0.00");
// });

Vue.use(DatePicker);
Vue.use(Upload);
Vue.use(Select);
Vue.use(Option);
Vue.use(Loading);
Vue.use(Input);
Vue.use(Checkbox);
Vue.use(Pagination);
Vue.use(Form);
Vue.use(Autocomplete);
Vue.use(Button);
Vue.prototype.$notify = Notification;
locale.use(lang);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

require("./example.js");
require("./pd.js");
require("./eam.js");
require("./om.js");
require("./ecom.js");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
