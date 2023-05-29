import { createWebHistory, createRouter } from "vue-router";

import routes from "@/router/routes";

import { useAuthStore } from "@/stores/auth";

const router = createRouter({
    history: createWebHistory(),
    linkActiveClass: "active",
    routes,
});

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();
    if (!authStore.user) {
        await authStore.getCurrentUser();
    }
    if (!authStore.user) {
        authStore.clearBrowserData();
    }
    const requiresAbility = to.meta.requiresAbility;
    const requiresAuth = to.meta.requiresAuth;
    const belongsToOwnerOnly = to.meta.isOwner;
    if (requiresAbility && requiresAuth) {
        if (authStore.hasAbilities(requiresAbility)) {
            next();
        } else {
            next({
                name: "profile",
            });
        }
    } else if (belongsToOwnerOnly) {
        if (authStore.user.is_owner) {
            next();
        } else {
            next({ name: "dashboard" });
        }
    } else {
        next();
    }
});

export default router;
