/* eslint-disable prettier/prettier */
import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";

const routes = [{
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/about",
        name: "About",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import ( /* webpackChunkName: "about" */ "../views/About.vue"),
    },
    {
        path: "/groupe/:id",
        name: "groupe",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import (
                /* webpackChunkName: "groupe" */
                "../views/groupe.vue"
            ),
    },
    {
        path: "/login",
        name: "login",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import (
                /* webpackChunkName: "login" */
                "../views/login.vue"
            ),
    },
    {
        path: "/register",
        name: "register",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import (
                /* webpackChunkName: "register" */
                "../views/register.vue"
            ),
    },
    {
        path: "/dashboard/:id",
        name: "dashboard",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import (
                /* webpackChunkName: "dashboard" */
                "../views/dashboard.vue"
            ),
    },
    {
        path: "/list_groupes",
        name: "groupes",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import (
                /* webpackChunkName: "groupes" */
                "../views/list_groupes"
            ),
    },
    {
        path: "/profile/:id",
        name: "profile",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import (
                /* webpackChunkName: "profile" */
                "../views/profile.vue"
            ),
    },
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
});

export default router;