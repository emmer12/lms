<template>
    <nav>
        <div class="h-20 navigation">
            <div class="container-x">
                <div class="wrapper">
                    <div class="logo">
                        <img class="mt-4" src="/assets/images/logo.png" />
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
                            <router-link to="#" v-slot="{ navigate }">
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
                            <div class="avatar" v-else>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import Button from "@/views/components/input/Button";
import { reactive } from "vue";
import { useAuthStore } from "@/stores/auth";

export default {
    components: {
        Button,
    },
    setup() {
        const { user, loggedIn } = useAuthStore();

        const state = reactive({
            isAccountDropdownOpen: false,
            isMobileMenuOpen: false,
            currentExpandedMenuItem: null,
            app: window.AppConfig,
        });

        return {
            state,
            user,
            loggedIn,
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
}
</style>
