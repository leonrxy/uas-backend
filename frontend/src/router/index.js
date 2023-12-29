// import Vue from "vue";
// import VueRouter from "vue-router";

import { createRouter, createWebHistory } from "vue-router";

//Vue.use(VueRouter);
const routes = [
  {
    path: "/mahasiswa",
    name: "mahasiswa.index",
    component: () => import("@/views/mahasiswa/Index.vue"),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("token");
      if (!token) {
        next({ name: "login" });
      } else {
        next();
      }
    },
  },
  {
    path: "/create",
    name: "mahasiswa.create",
    component: () => import("@/views/mahasiswa/Create.vue"),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("token");
      if (!token) {
        next({ name: "login" });
      } else {
        if (localStorage.getItem("role") !== "admin") {
          next({ name: "mahasiswa.index" });
        } else {
          next();
        }
      }
    },
  },
  {
    path: "/edit/:id",
    name: "mahasiswa.edit",
    component: () => import("@/views/mahasiswa/Edit.vue"),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("token");
      if (!token) {
        next({ name: "login" });
      } else {
        if (localStorage.getItem("role") !== "admin") {
          next({ name: "mahasiswa.index" });
        } else {
          next();
        }
      }
    },
  },
  {
    path: "/",
    name: "index",
    component: () => import("@/views/auth/Login.vue"),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("token");
      if (!token) {
        next({ name: "login" });
      } else {
        next({ name: "mahasiswa.index" });
      }
    },
  },
  {
    path: "/login",
    name: "login",
    component: () => import("@/views/auth/Login.vue"),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("token");
      if (token) {
        next({ name: "mahasiswa.index" });
      } else {
        next();
      }
    },
  },
  {
    path: "/register",
    name: "register",
    component: () => import("@/views/auth/Register.vue"),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("token");
      if (token) {
        next({ name: "mahasiswa.index" });
      } else {
        next();
      }
    },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes, // config routes
});
export default router;
