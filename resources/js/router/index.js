import { createWebHistory, createRouter } from "vue-router";

import Store from "../pages/Store.vue";
import Pos from "../pages/Pos.vue";
import Transection from "../pages/Transection.vue";
import Report from "../pages/Report.vue";
import NoPage from "../pages/NoPage.vue"

export const routes = [
    {
        name:"store",
        path: "/",
        component: Store
    },
    {
        name:"pos",
        path: "/pos",
        component: Pos
    },
    {
        name:"transection",
        path: "/transection",
        component: Transection
    },
    {
        name:"report",
        path: "/report",
        component: Report
    },
    {
        name: "no-page",
        path: "/:pathMactch(.*)*",
        component: NoPage
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior(){
        window.scrollTo(0,0)
    }
});

export default router;