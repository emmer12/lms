<template>
    <nav>
        <div class="h-20 navigation">
            <div class="container-x">
                <div class="wrapper">
                    <div class="logo">
                        <router-link to="/"
                            ><img class="mt-4" src="/assets/images/logo.png"
                        /></router-link>
                    </div>
                    <div class="menu">
                        <ul class="left">
                            <router-link to="/" v-slot="{ navigate }">
                                <li @click="navigate">Home</li>
                            </router-link>
                            <router-link
                                :to="{ name: 'courses' }"
                                v-slot="{ navigate }"
                            >
                                <li @click="navigate">All Courses</li>
                            </router-link>
                            <router-link to="/about" v-slot="{ navigate }">
                                <li @click="navigate">About</li>
                            </router-link>
                        </ul>
                    </div>
                    <div class="action">
                        <div class="right">
                            <button class="search-trigger">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    class="bi bi-search"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"
                                    />
                                </svg>
                            </button>
                            <Button
                                v-if="!loggedIn"
                                to="/login"
                                label="Login/Register"
                            />
                            <div class="avatar relative" v-else>
                                <div
                                    class="cursor-pointer flex"
                                    @click="
                                        state.isAccountDropdownOpen =
                                            !state.isAccountDropdownOpen
                                    "
                                >
                                    <img
                                        v-if="user.avatar_url"
                                        :src="user.avatar_url"
                                        alt="Avatar"
                                    />
                                    <img
                                        v-else
                                        :src="`https://eu.ui-avatars.com/api/?name=${user.full_name}&size=50`"
                                        alt="Avatar"
                                    />

                                    <!-- <span class="relative pt-3 mr-2 ml-2">
                                        <Icon
                                            :name="
                                                state.isAccountDropdownOpen
                                                    ? 'angle-up'
                                                    : 'angle-down'
                                            "
                                    /></span> -->
                                </div>
                                <transition
                                    @before-enter="beforeEnter"
                                    @enter="enter"
                                    @leave="leave"
                                    name="toggle"
                                    mode="in-out"
                                >
                                    <div
                                        v-if="state.isAccountDropdownOpen"
                                        class="hidden sm:block absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-4 z-50"
                                    >
                                        <router-link
                                            to="/panel/dashboard"
                                            class="block px-4 py-2 hover:bg-theme-800 hover:text-white hover:opacity-80"
                                        >
                                            {{ trans("Dashboard") }}
                                        </router-link>

                                        <router-link
                                            to="/panel/my-courses"
                                            class="block px-4 py-2 hover:bg-theme-800 hover:text-white hover:opacity-80"
                                        >
                                            {{ trans("My Courses") }}
                                        </router-link>

                                        <a
                                            href="#"
                                            @click.prevent="onLogout"
                                            class="block px-4 py-2 hover:bg-theme-800 hover:text-white hover:opacity-80"
                                            >{{
                                                trans("global.phrases.sign_out")
                                            }}</a
                                        >
                                    </div>
                                </transition>
                                <transition
                                    @before-enter="beforeEnter"
                                    @enter="enter"
                                    @leave="leave"
                                    name="toggle"
                                    mode="in-out"
                                >
                                    <div
                                        v-if="state.isAccountDropdownOpen"
                                        class="mobile-menu w-32 bg-white rounded-lg shadow-lg py-2 mt-4 z-50"
                                    >
                                        <router-link
                                            to="/panel/dashboard"
                                            class="block px-4 py-2 hover:bg-theme-800 hover:text-white hover:opacity-80"
                                        >
                                            {{ trans("Dashboard") }}
                                        </router-link>

                                        <router-link
                                            to="/panel/my-courses"
                                            class="block px-4 py-2 hover:bg-theme-800 hover:text-white hover:opacity-80"
                                        >
                                            {{ trans("My Courses") }}
                                        </router-link>

                                        <a
                                            href="#"
                                            @click.prevent="onLogout"
                                            class="block px-4 py-2 hover:bg-theme-800 hover:text-white hover:opacity-80"
                                            >{{
                                                trans("global.phrases.sign_out")
                                            }}</a
                                        >
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import { trans } from "@/helpers/i18n";
import Button from "@/views/components/input/Button";
import { reactive } from "vue";
import Icon from "@/views/components/icons/Icon";
import { useAuthStore } from "@/stores/auth";
import gsap from "gsap";

export default {
    components: {
        Button,
        Icon,
    },
    setup() {
        const { user, loggedIn, logout } = useAuthStore();

        const state = reactive({
            isAccountDropdownOpen: false,
            isMobileMenuOpen: false,
            currentExpandedMenuItem: null,
            app: window.AppConfig,
        });

        function onLogout() {
            logout();
        }

        const beforeEnter = (el) => {
            el.style.opacity = 0;
            el.style.top = 150;
        };
        const enter = (el, done) => {
            gsap.to(el, {
                opacity: 1,
                y: 10,
                duration: 0.5,
                onComplete: done,
            });
        };
        const leave = (el, done) => {
            gsap.to(el, {
                opacity: 0,
                duration: 0.3,
                y: -50,
                onComplete: done,
            });
        };

        return {
            state,
            user,
            loggedIn,
            onLogout,
            trans,
            beforeEnter,
            enter,
            leave,
        };
    },
};
</script>

<style lang="scss" scoped>
.navigation {
    background: #fff;
    box-shadow: 0 3px 9px rgb(0 0 0 / 5%);
    .wrapper {
        display: flex;
        height: 80px;
        color: #231f40;
        align-items: center;

        justify-content: space-between;
        .menu {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* flex: 1; */
            ul {
                li {
                    color: #231f40;
                    padding: 15px;
                    font-size: 16px;
                    font-weight: 700;
                    /* text-transform: uppercase; */
                }
            }
            .left {
                display: inline-flex;
                position: relative;

                &:after {
                    content: "";
                    position: absolute;
                    height: 100%;
                    width: 2px;
                    background: #fff;
                    left: -50px;
                }
            }
        }
        .right {
            display: inline-flex;
            align-items: center;
            height: 100%;
        }
    }
    .search-trigger {
        height: 50px;
        line-height: 50px;
        width: 50px;
        text-align: center;
        box-shadow: 0 8px 20px rgb(0 0 0 / 6%);
        border-radius: 5px;
        outline: none;
        color: var(--primary);
        border: 0 none;
        padding: 0;
        background: var(--color-white);
        display: block;
        font-size: 16px;
        border-radius: 5px;
        margin: 0px 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar {
        box-shadow: 0 8px 20px rgb(0 0 0 / 6%);
        border-radius: 5px;
        border: 4px solid #fff;
    }
}

@media (max-width: 640px) {
    .navigation {
        .wrapper {
            .menu {
                display: none;
                /* flex: 1; */
            }
        }
    }

    .mobile-menu {
        top: 92px;
        left: 50%;
        position: fixed;
        z-index: 22222;
        transform: translateX(-50%);
        width: 90%;
    }
}
</style>
