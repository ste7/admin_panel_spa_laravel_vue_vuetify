import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from './../../app/components/Home.vue'

Vue.use(VueRouter)

const router = new VueRouter({
        routes: [
            {
                path: '/',
                name: 'home',
                component: Home,
                meta: {
                    auth: true
                }
            }
        ]
});

import beforeEach from './beforeEach'

router.beforeEach(beforeEach)

export default router