import Vue from "vue";
import VueRouter from "vue-router";
import { getAuth, onAuthStateChanged } from "firebase/auth";
import HomeComponent from "../components/view/HomeComponent.vue";
import Attendance from "../components/view/AttendanceComponent.vue";
import Students from "../components/view/StudentsComponent.vue";
import Subjects from "../components/view/SubjectsComponent.vue";
import Teachers from "../components/view/TeachersComponent.vue";

Vue.use(VueRouter);

const router = new VueRouter({
  mode: "history",
  base: import.meta.env.BASE_URL,
  linkExactActiveClass: "active",
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeComponent,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: "/attendance",
      name: "attendance",
      component: Attendance,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: "/students",
      name: "students",
      component: Students,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: "/subjects",
      name: "subjects",
      component: Subjects,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: "/teachers",
      name: "teachers",
      component: Teachers,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: "/login",
      name: "login",
      component: () => import("../components/auth/LoginComponent.vue"),
      meta: {
        hideForAuth: true,
      },
    },
    {
      path: "/register",
      name: "register",
      component: () => import("../components/auth/RegisterComponent.vue"),
      meta: {
        hideForAuth: true,
      },
    },
    {
      path: "/landing",
      name: "landing",
      component: () => import("../components/LandingPage.vue"),
    },
  ],
});

const getCurrentUser = () => {
  return new Promise((resolve, reject) => {
    const removeListener = onAuthStateChanged(
      getAuth(),
      (user) => {
        removeListener();
        resolve(user);
      },
      reject
    );
  });
};

router.beforeEach(async (to, from, next) => {
  if (to.matched.some((record) => record.meta.hideForAuth)) {
    if (await getCurrentUser()) {
      next("/");
    } else {
      next();
    }
  } else {
    next();
  }

  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (await getCurrentUser()) {
      next();
    } else {
      next("/landing");
    }
  } else {
    next();
  }
});

export default router;
