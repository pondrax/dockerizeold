
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
import ElementPlus from 'element-plus';
import 'element-plus/lib/theme-chalk/index.css';
import Export from './components/Export.vue';

const app = vue.createApp(App).use(ElementPlus);
app.config.globalProperties.$config = config;

const mixin = {
	methods:{
		url(endpoint){
			return endpoint.indexOf('http')>-1 ? endpoint: this.$config.url + endpoint;
		},
		http(url){
			return axios(url);
		},
		dayjs(date, format){
			var list = {
				date 		: 'YYYY-MM-DD',
				datetime 	: 'YYYY-MM-DD HH:mm:ss',
				time 		: 'HH:mm:ss',
			};
			format = format?
						list[format]? list[format]: format
						: list['date'];
			return dayjs(date).format(format);
		}
	}
};
app.mixin(mixin);
app.component('Export', Export);

window.app = app.mount('#app');

window.removeEmpty = (obj) => {
  Object.keys(obj).forEach(k =>
    (obj[k] && typeof obj[k] === 'object') && removeEmpty(obj[k]) ||
    (!obj[k] && obj[k] !== undefined) && delete obj[k]
  );
  return obj;
};
