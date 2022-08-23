require('./bootstrap');

window.moment = require('moment');

require('pace-js');
require('select2');
require('jquery.cookie');

require('datatables.net-dt');
require('datatables.net-bs4');
require('datatables.net-responsive-dt');

require('admin-lte');

import Sortable from 'sortablejs';
window.Sortable = Sortable;

const { Dropzone } = require("dropzone");
// window.Dropzone = require('dropzone');
Dropzone.autoDiscover = false;

require('lightbox2');
require('summernote/dist/summernote-bs4.js');

require('pc-bootstrap4-datetimepicker');
require('daterangepicker');

require('cropperjs');
require('jquery-cropper');

require('chart.js');
/*
window.Vue = require('vue');
// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app'
});
*/
