/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.vue = require('vue');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common = {
    //'X-Requested-With': 'XMLHttpRequest'
};

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

//window.dayjs = require('dayjs');

function TaskRunner(concurrency) {
	this.limit = concurrency;
	this.store = [];
	this.active = 0;

	this.next = function() {
		if (this.store.length) this.runTask(...this.store.shift())
	}
	this.runTask = function(task, name) {
		this.active++
		//console.log(`Scheduling task ${name} current active: ${this.active}`)
		task(name).finally(()=>{
			this.active--
			 //console.log(`Task ${name} returned, current active: ${this.active}`)
			this.next()
		});
	}
	this.push = function(task, name) {
		if (this.active < this.limit) this.runTask(task, name)
		else {
			//console.log(`queuing task ${name}`)
			this.store.push([task, name])
		}
	}
}

window.Task = new TaskRunner(1);

window.removeEmpty = (obj) => {
  Object.keys(obj).forEach(k =>
    (obj[k] && typeof obj[k] === 'object') && removeEmpty(obj[k]) ||
    (!obj[k] && obj[k] !== undefined) && delete obj[k]
  );
  return obj;
};

Array.prototype.first = (arr) => arr[0];
