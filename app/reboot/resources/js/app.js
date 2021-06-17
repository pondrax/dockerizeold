
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
import App from './App.vue';
import {createI18n} from 'vue-i18n';
import mixin from './plugins/mixin.js';
import messages from './plugins/messages.js';
import datetimeFormats from './plugins/datetime.js';
import Export from './components/Export.vue';

import ElementPlus from 'element-plus';
import 'element-plus/lib/theme-chalk/index.css';
import '../sass/app.scss';

const app = vue.createApp(App);
const i18n = createI18n({
	locale: 'id',
	fallbackLocale:'en',
	messages,
	datetimeFormats,
});

app.use(i18n);
app.use(ElementPlus, {
  i18n: i18n.global.t,
})

app.config.globalProperties.$config = config;
app.mixin(mixin);
app.component('Export', Export);

window.app = app.mount('#app');
