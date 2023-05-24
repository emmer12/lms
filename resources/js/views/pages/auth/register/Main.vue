<template>
    <Auth>
        <h2 class="font-black text-4xl">
            {{ trans("global.pages.register") }}
        </h2>
        <p class="text-sm mt-4 mb-4 font-normal">
            {{ trans("global.phrases.register_desc") }}
        </p>
        <RegisterForm />
        <div
            class="mt-5 text-sm flex justify-between items-center text-[#002D74] border-t border-[#002D74] pt-3"
        >
            <p>{{ trans("global.phrases.login_ask") }}</p>
            <router-link
                to="/login"
                class="py-2 px-5 bg-white text-theme-700 border rounded hover:scale-110 duration-300"
            >
                {{ trans("global.buttons.login") }}
            </router-link>
        </div>
    </Auth>
</template>

<script>
import { default as RegisterForm } from "@/views/pages/auth/register/Form";
import { trans } from "@/helpers/i18n";
import Auth from "@/views/layouts/Auth";

export default {
    name: "RegisterView",
    components: {
        Auth,
        RegisterForm,
    },
    setup() {
        return {
            trans,
        };
    },
};
</script>
