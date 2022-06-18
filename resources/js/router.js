import { createRouter, createWebHistory } from 'vue-router'

import Dashboard from './components/partials/_dashboard.vue'
import indexMain from './components/partials/IndexMain.vue'
import Login from './components/Auth/login.vue'
import Register from './components/Auth/register.vue'
import Roles from '../js/components/Roles/index.vue'
import Users from './components/Users/index.vue'
import ExpenseCategory from './components/ExpsenseCategory/index.vue'
import Expenses from './components/Expenses/index.vue'

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
                name: 'Roles',
                path: '/roles',
                meta: { requiresAuth: true },
                component: Roles
            },
            {
                name: 'Users',
                path: '/users',
                meta: { requiresAuth: true },
                component: Users
            },
            {
                name: 'ExpenseCategory',
                path: '/expense-category',
                meta: { requiresAuth: true },
                component: ExpenseCategory
            },
            {
                name: 'Expenses',
                path: '/expense',
                meta: { requiresAuth: true },
                component: Expenses
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
