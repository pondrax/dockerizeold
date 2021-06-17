export default {
	methods:{
		url(endpoint){
			return endpoint.indexOf('http:')>-1 ? endpoint: this.$config.url + endpoint;
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
		},
	}
};
