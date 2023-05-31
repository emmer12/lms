<template>
    <div
        class="flex"
        v-if="
            authStore.user &&
            authStore.user.hasOwnProperty('id') &&
            $route.path.includes('panel')
        "
    >
        <aside
            class="relative bg-white h-screen w-64 hidden sm:block shadow-xl"
        >
            <div class="p-6 border-b border-theme-600">
                <router-link
                    class="text-white text-3xl font-semibold uppercase hover:text-gray-300"
                    to="/panel/dashboard"
                >
                    <template v-if="state.app.logo">
                        <img :src="state.app.logo" :alt="state.app.name" />
                    </template>
                    <template v-else>
                        {{ state.app.name }}
                    </template>
                </router-link>
                <template
                    v-if="state.headerLeftLink && authStore.user.is_admin"
                >
                    <a
                        v-if="state.headerLeftLink.href"
                        :href="state.headerLeftLink.href"
                        class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center"
                    >
                        <Icon :name="state.headerLeftLink.icon" class="mr-3" />
                        {{ state.headerLeftLink.name }}
                    </a>
                    <router-link
                        v-else
                        :to="state.headerLeftLink.to"
                        class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center"
                    >
                        <Icon :name="state.headerLeftLink.icon" class="mr-3" />
                        {{ state.headerLeftLink.name }}
                    </router-link>
                </template>
            </div>
            <nav class="text-white text-base py-4 px-3 rounded">
                <Menu :state="state" :type="'desktop'" />
            </nav>
            <template v-if="state.footerLeftLink">
                <a
                    v-if="state.footerLeftLink.href"
                    :href="state.footerLeftLink.href"
                    class="absolute w-full bottom-0 bg-theme-800 text-white flex items-center justify-center py-4"
                >
                    <Icon :name="state.footerLeftLink.icon" class="mr-3" />
                    {{ state.footerLeftLink.name }}
                </a>
                <router-link v-else :to="state.footerLeftLink.to">
                    <Icon :name="state.footerLeftLink.icon" class="mr-3" />
                    {{ state.footerLeftLink.name }}
                </router-link>
            </template>
        </aside>
        <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
            <!-- Desktop Header -->
            <header
                class="w-full items-center bg-[#fff] py-2 px-6 hidden sm:flex"
            >
                <div class="w-1/2">
                    <h4 class="font-bold text-2xl capitalize">
                        <!-- {{ $route.name }} -->
                    </h4>
                </div>
                <div class="relative w-1/2 flex justify-end">
                    <div class="mr-5 self-center cursor:pointer">
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 20 20"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M1.40408 15H18.5858C19.3668 15 20 14.3668 20 13.5858C20 13.2107 19.851 12.851 19.5858 12.5858L18.5858 11.5858C18.2107 11.2107 18 10.702 18 10.1716L18 7.96958C18 3.5681 14.4319 0 10.0304 0C5.61873 0 2.04641 3.58403 2.06086 7.99568L2.06791 10.1473C2.06969 10.692 1.84919 11.2139 1.45736 11.5924L0.428635 12.586C0.154705 12.8506 2.07459e-06 13.2151 0 13.5959C0 14.3714 0.628628 15 1.40408 15ZM12.584 17C13.2374 17 13.7129 17.6278 13.357 18.1758C12.6439 19.2738 11.4067 20 9.99996 20C8.59319 20 7.35604 19.2738 6.64294 18.1758C6.28703 17.6278 6.76251 17 7.41595 17H12.584Z"
                                fill="#9DA6BA"
                            />
                        </svg>
                    </div>
                    <a
                        class="flex cursor-pointer focus:outline-none align-middle"
                        @click="
                            state.isAccountDropdownOpen =
                                !state.isAccountDropdownOpen
                        "
                    >
                        <button
                            class="relative z-10 w-12 h-12 rounded-full overflow-hidden"
                        >
                            <img
                                :alt="authStore.user.full_name"
                                v-if="authStore.user.avatar_url"
                                :src="authStore.user.avatar_url"
                            />
                            <img
                                v-else
                                :src="`https://eu.ui-avatars.com/api/?name=${authStore.user.full_name}&size=50`"
                                alt="Avatar"
                            />
                        </button>
                    </a>
                    <button
                        v-if="state.isAccountDropdownOpen"
                        @click="state.isAccountDropdownOpen = false"
                        class="h-full w-full fixed inset-0 cursor-pointer"
                    ></button>
                    <span class="relative pt-3 mr-2 ml-2">
                        <!-- {{ authStore.user.full_name }} -->
                        <Icon
                            :name="
                                state.isAccountDropdownOpen
                                    ? 'angle-up'
                                    : 'angle-down'
                            "
                    /></span>
                    <div
                        v-if="state.isAccountDropdownOpen"
                        class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16 z-50"
                    >
                        <router-link
                            to="/panel/profile"
                            class="block px-4 py-2 hover:bg-theme-800 hover:text-white hover:opacity-80"
                        >
                            {{ trans("global.pages.profile") }}
                        </router-link>
                        <a
                            href="#"
                            @click.prevent="onLogout"
                            class="block px-4 py-2 hover:bg-theme-800 hover:text-white hover:opacity-80"
                            >{{ trans("global.phrases.sign_out") }}</a
                        >
                    </div>
                </div>
            </header>

            <!-- Mobile Header & Nav -->
            <header class="w-full bg-white py-4 px-6 sm:hidden">
                <div class="flex items-center justify-between">
                    <router-link to="/">
                        <router-link
                            class="text-white text-3xl font-semibold uppercase hover:text-gray-300"
                            to="/panel/dashboard"
                        >
                            <template v-if="state.app.logo">
                                <img
                                    :src="state.app.logo"
                                    :alt="state.app.name"
                                />
                            </template>
                            <template v-else>
                                {{ state.app.name }}
                            </template>
                        </router-link>
                    </router-link>
                    <button
                        @click="
                            state.isMobileMenuOpen = !state.isMobileMenuOpen
                        "
                        class="text-gray-800 text-3xl focus:outline-none"
                    >
                        <i
                            v-if="!state.isMobileMenuOpen"
                            class="fa fa-bars"
                        ></i>
                        <i v-else class="fa fa-times"></i>
                    </button>
                </div>
                <nav
                    :class="state.isMobileMenuOpen ? 'flex' : 'hidden'"
                    class="flex flex-col pt-4 text-base text-white"
                >
                    <Menu :state="state" :type="'mobile'" />
                </nav>
            </header>

            <div class="w-full h-screen overflow-x-hidden flex flex-col">
                <main class="w-full flex-grow p-6">
                    <router-view />
                </main>
                <footer
                    class="w-full bg-white text-center text-sm p-4"
                    v-html="trans('global.phrases.copyright')"
                ></footer>
            </div>
        </div>
    </div>
    <div
        v-else-if="
            authStore.user &&
            authStore.user.hasOwnProperty('id') &&
            !$route.path.includes('panel')
        "
    >
        <GuestNav
            v-if="!['my.learning', 'my.learning.lesson'].includes($route.name)"
        />
        <!-- <LearningNav v-else /> -->
        <router-view />
    </div>
    <template v-else>
        <GuestNav
            v-if="!['login', 'register', 'forget'].includes($route.name)"
        />
        <router-view />
    </template>
</template>

<script>
import { computed, onBeforeMount, reactive } from "vue";

import { trans } from "@/helpers/i18n";
import Menu from "@/views/layouts/Menu";
import GuestNav from "@/views/components/GuestNav";
// import LearningNav from "@/views/components/LearningNav";
import Icon from "@/views/components/icons/Icon";
import AvatarIcon from "@/views/components/icons/Avatar";
import { useAuthStore } from "@/stores/auth";
import { useGlobalStateStore } from "@/stores";
import { useRoute } from "vue-router";
import { useAlertStore } from "@/stores";
import { getAbilitiesForRoute } from "@/helpers/routing";

export default {
    name: "app",
    components: {
        AvatarIcon,
        Menu,
        Icon,
        GuestNav,
        // LearningNav,
    },
    setup() {
        const alertStore = useAlertStore();
        const authStore = useAuthStore();
        const globalStateStore = useGlobalStateStore();
        const route = useRoute();

        const isLoading = computed(() => {
            var value = false;
            for (var i in globalStateStore.loadingElements) {
                if (globalStateStore.loadingElements[i]) {
                    value = true;
                    break;
                }
            }
            return value || globalStateStore.isUILoading;
        });

        const state = reactive({
            mainMenu: [
                {
                    name: trans("global.pages.home"),
                    icon: "tachometer",
                    showDesktop: true,
                    showMobile: true,
                    requiresAbility: false,
                    to: "/panel/dashboard",
                },
                {
                    name: "My Courses",
                    icon: "book",
                    showDesktop: true,
                    showMobile: true,
                    requiresAbility: false,
                    to: "/panel/my-courses",
                },
                {
                    name: trans("global.pages.users"),
                    icon: "users",
                    showDesktop: true,
                    showMobile: true,
                    requiresAbility: getAbilitiesForRoute([
                        "users.list",
                        "users.create",
                        "users.edit",
                    ]),
                    to: "/panel/users/list",
                    children: [
                        {
                            name: trans("global.phrases.all_records"),
                            icon: "",
                            showDesktop: true,
                            showMobile: true,
                            requiresAbility: getAbilitiesForRoute("users.list"),
                            to: "/panel/users/list",
                        },
                        {
                            name: trans("global.buttons.add_new"),
                            icon: "",
                            showDesktop: true,
                            showMobile: true,
                            requiresAbility:
                                getAbilitiesForRoute("users.create"),
                            to: "/panel/users/create",
                        },
                    ],
                },
                {
                    name: trans("Courses"),
                    icon: "book",
                    showDesktop: true,
                    showMobile: true,
                    requiresAbility: getAbilitiesForRoute(["*"]),
                    to: "/panel/course/list",
                    children: [
                        {
                            name: trans("global.phrases.all_records"),
                            icon: "",
                            showDesktop: true,
                            showMobile: true,
                            requiresAbility: getAbilitiesForRoute("*"),
                            to: "/panel/course/list",
                        },
                        {
                            name: trans("Create"),
                            icon: "",
                            showDesktop: true,
                            showMobile: true,
                            requiresAbility: getAbilitiesForRoute("*"),
                            to: "/panel/course/create",
                        },
                    ],
                },
                {
                    name: "My Profile",
                    icon: "user",
                    showDesktop: true,
                    showMobile: true,
                    requiresAbility: false,
                    to: "/panel/profile",
                },
                {
                    name: trans("global.phrases.sign_out"),
                    icon: "sign-out",
                    showDesktop: false,
                    showMobile: true,
                    showIfRole: false,
                    onClick: onLogout,
                    to: "",
                },
            ],
            headerLeftLink: {
                name: trans("New Course"),
                icon: "plus",
                to: "panel/course/create",
            },
            // footerLeftLink: {
            //     name: trans("global.buttons.documentation"),
            //     icon: "paperclip",
            //     to: "",
            //     href: "#",
            // },
            isAccountDropdownOpen: false,
            isMobileMenuOpen: false,
            currentExpandedMenuItem: null,
            app: window.AppConfig,
        });

        function onLogout() {
            authStore.logout();
        }

        onBeforeMount(() => {
            if (
                route.query.hasOwnProperty("verified") &&
                route.query.verified
            ) {
                alertStore.success(trans("global.phrases.email_verified"));
            }
        });

        return {
            state,
            authStore,
            globalStateStore,
            trans,
            onLogout,
            isLoading,
        };
    },
};
</script>
