// 1. Define route components.
// These can be imported from other files
import Vue from "vue";
import VueRouter from "vue-router";
import Home from "./components/HomeComponent.vue";
import Subjects from "./components/SubjectsComponent.vue";
import Attendance from "./components/AttendanceComponent.vue";
import Students from "./components/StudentsComponent.vue";
import Teachers from "./components/TeachersComponent.vue";
import NotFound from "./components/NotFound.vue";

Vue.use(VueRouter);
// 2. Define some routes
// Each route should map to a component.
// We'll talk about nested routes later.
const routes = [
    { path: "/", component: Home },
    { path: "/home", component: Home },
    { path: "/attendance", component: Attendance },
    { path: "/teachers", component: Teachers },
    { path: "/students", component: Students },
    { path: "/subjects", component: Subjects },
];
// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    mode: "history",
    routes, // short for `routes: routes`
    linkExactActiveClass: "active",
});

// 5. Create and mount the root instance.
// const app = Vue.createApp({});
// Make sure to _use_ the router instance to make the
// whole app router-aware.
// app.use(router);

// app.mount("#app");

// Now the app has started!

export default router;
