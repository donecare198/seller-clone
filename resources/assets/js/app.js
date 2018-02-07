import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App.vue'

Vue.use(VueRouter)

const routes = [
    { path: '/',component: require('./components/home.vue') },
    { path: '/_=_',component: require('./components/home.vue') },
    { path: '/trash',component: require('./components/cloneTrash.vue') },
    { path: '/home',component: require('./components/home.vue') },
    { path: '/checklive',component: require('./components/checklive.vue') },
    { path: '/clone',component: require('./components/clone.vue') },
    { path: '/naptien',component: require('./components/billing.vue') },    
    
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