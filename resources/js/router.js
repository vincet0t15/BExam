import { createRouter, createWebHistory } from 'vue-router'

import Dashboard from './components/partials/_dashboard.vue'
import indexMain from './components/partials/IndexMain.vue'
import Login from './components/Auth/login.vue'
import Register from './components/Auth/register.vue'

import CategoryList from './components/Category/index.vue'
import createCategory from './components/Category/create.vue'
import updateCategory from './components/Category/update.vue'

import productList from './components/Products/index.vue'
import createProduct from './components/Products/create.vue'
import updateProduct from './components/Products/update.vue'

import multistep from './components/Products/multistep.vue'
import mulitsteps from './components/Products/mulitstep.vue'
function isLoggedIn() {
    return localStorage.getItem("token");
}

const routes = [
    {
        name: 'Main',
        path: '/',
        component: indexMain,
        meta: { requiresAuth: true },
        children: [
            {

                path: '',
                meta: { requiresAuth: true },
                component:Dashboard
            },
            {
                name: 'Dashboard',
                path: '/dashboard',
                meta: { requiresAuth: true },
                component:Dashboard
            },
            {
                name: 'CategoryList',
                path: '/categories',
                meta: { requiresAuth: true },
                component: CategoryList
            },
            {
                name: 'createCategory',
                path: '/create-category',
                meta: { requiresAuth: true },
                component: createCategory
            },
            {
                name: 'updateCategory',
                path: '/update-category/:id',
                meta: { requiresAuth: true },
                component: updateCategory
            },
            {
                name: 'productList',
                path: '/products',
                meta: { requiresAuth: true },
                component: productList
            },
            {
                name: 'createProduct',
                path: '/create-products',
                meta: { requiresAuth: true },
                component: createProduct
            },
            {
                name: 'updateProduct',
                path: '/update-products/:id',
                meta: { requiresAuth: true },
                component: updateProduct
            },
            {
                name: 'multi',
                path: '/multi',
                meta: { requiresAuth: true },
                component: multistep
            },
            {
                name: 'mult',
                path: '/mult',
                meta: { requiresAuth: true },
                component: mulitsteps
            },
        ]
    },
    {
        name: 'Login',
        path: '/login',
        meta: { guest: true },
        component: Login

    },
    {
        name: 'Register',
        path: '/register',
        meta: { guest: true },
        component: Register
    },
];


const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "active",
})


router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {

        if (!isLoggedIn()) {
            next({
                path: '/login',
                // query: { redirect: to.fullPath }
            })
        } else {
            if(to.path=== '/mail'){
                router.push({name:"Compose"})
            }else{
                next()
            }
            
        }
    } else if (to.matched.some(record => record.meta.guest)) {
        if (isLoggedIn()) {
            next({
                path: '/dashboard',
                // query: { redirect: to.fullPath }
            })
        } else {
            next()
        }
    } else {
        next() // make sure to always call next()!
    }
})

export default router;
