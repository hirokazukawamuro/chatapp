import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/chat/:id", component: () => import("../js/components/Chat.vue")},
  ],
});

export default router;