import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App.vue'

Vue.use(VueRouter)

const routes = [
    { path: '/',component: require('./components/home.vue') },
    
]
const router = new VueRouter({
    routes
})
new Vue({
    el: '#app',
    router,
    template: '<App/>',
    components: { App }
}).$mount('#hihi')



