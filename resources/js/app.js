require('./bootstrap');
import Vue from 'vue'
window.Vue = require('vue');


Vue.component('layout-app', require('./layouts/Application.vue').default)

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Start Turbolinks
require('turbolinks').start()

// Boot the current Vue component
document.addEventListener('turbolinks:load', (event) => {
    const root = document.getElementById('app')

    console.log(root.dataset.component);
    console.log(typeof root.dataset.props);


    if (app) {
        app.$destroy(true)
    }
    const app = new Vue({
        render: h => h(
            Vue.component(root.dataset.component), {
            props: JSON.parse(root.dataset.props)
        }
        )
    }).$mount('#app')
})
