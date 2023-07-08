import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/chat/:linkId/:userId",
      name: "Chat",
      component: () => import("../js/components/Chat.vue"),
      props:true,
    } 
  ],
});

export default router;