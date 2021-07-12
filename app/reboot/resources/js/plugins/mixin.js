export default {
	methods:{
		url(endpoint){
			endpoint =  endpoint.indexOf('http:')>-1 ? endpoint: this.$config.url + endpoint;
			return endpoint.replace(/\/?$/, '/')
		},
		http(url){
			axios.defaults.headers.common['Authorization'] = 'Bearer test';
			return axios(url);
		},
		selectionChange(selection){
			this.info.selections=selection;
		},
		sortChange({prop,order}){
			this.query.sort=prop;
			this.query.order=order;
			this.getData();
		},
		sizeChange(val){
			this.query.limit = val;
		},
		getData(){
			this.info.loading = true;
			var query = new URLSearchParams(removeEmpty(this.query));
			this.http(this.url(this.endpoint) + 'read?' + query)
				.then(response=>{
					this.data = response.data.data;
					this.query.page = response.data.current_page;
					this.info.total = response.data.total;
				})
				.catch(error=>{
					this.$message({type: 'error', message: this.$t('page.error')});
				})
				.finally(()=>this.info.loading = false);
		},

		getSelectData(){
			Object.keys(this.options).map(key=>{
				if(this.options[key].endpoint !=null){
					var url = this.url(this.options[key].endpoint) + this.options[key].query + '&limit=-1';
					this.http(url).then(response=>{
						this.options[key].list = response.data.data;
					});
				}
			})
		},
		getDetail(prop){
			this.info.drawer = true;
			this.form = Object.assign({},prop);
		},
		validateData(e){
			console.log(e)
			this.updateData('validate');
		},
		updateData(prevalidate){
			//this.info.loading = true;
			var form 		= this.form;
			var validate	= prevalidate == 'validate'? '?validate': '';
			var id      	= form.id? form.id : '';
			this.http({
					url 	: this.url(this.endpoint) + id + validate,
					method	: form.id? 'put': 'post',
					data	: form
				})
				.then(response=>{
					if(prevalidate != 'validate'){
						this.$message({type: 'success', message: response.data.message});
						this.info.drawer = false;
						this.getData();
					}
					this.error	= {};
				})
				.catch(error=>{
					var err = error.response.data.errors;
					Object.keys(err).forEach(e=>{
						err[e] = err[e].join(',')
					})
					this.error	= err;
					if(prevalidate != 'validate'){
						this.$message({type: 'error', message: error.response.data.message});
					}
				})
				.finally(()=>this.info.loading = false);
		},
		deleteData(id){
			this.http({
					url 	: this.url(this.endpoint) + id,
					method	: 'delete'
				})
				.then(response=>{
					this.$message({type: 'success', message: response.data.message});
					this.getData();
				})
				.catch(error=>{
					this.$message({type: 'error', message: error.response.data.message});
				});
		},
		confirmDelete(id){
			if(this.info.selections.length>0){
				id = this.info.selections.map(sel=>sel.id).join(',');
			}
			this.$confirm(this.$t('confirm.delete'), 'Warning', {type: 'warning'})
			.then(() => {
				this.deleteData(id);
			})
		}
	}
};
