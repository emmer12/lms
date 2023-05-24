<template>
    <main class="bg-white flex items-center justify-center min-h-screen">
        <div class="container bg-white flex items-center">
            <div
                class="rounded-2xl side md:block hidden min-h-screen w-1/2 flex-1"
            >
                <div class="logo">
                    <router-link to="/">
                        <img class="mt-4" src="/assets/images/logo.png"
                    /></router-link>
                </div>

                <div class="content">
                    <h2>Start Your Learning Journey With Us.</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Dicta sapiente dolor, consequuntur laborum a quos vel
                        repellat illo neque non natus voluptate. Beatae
                        possimus, vel libero tempora amet quos ex?
                    </p>
                </div>
            </div>

            <div class="md:w-1/2 px-8 md:px-16 py-8 flex-1">
                <slot></slot>
            </div>
        </div>
    </main>
</template>

<script>
import { defineComponent } from "vue";
import { trans } from "@/helpers/i18n";

export default defineComponent({
    name: "Auth",
    setup() {
        let AppConfig = window.AppConfig;

        return {
            trans,
            AppConfig,
        };
    },
});
</script>

<style lang="scss" scoped>
.side {
    background: linear-gradient(#79a4e1, #3b58ba);
    max-width: 560px;
    padding: 40px;

    .content {
        margin-top: 100px;

        h2 {
            color: #fff;
            font-size: 40px;
            font-weight: 800;
        }

        p {
            color: rgba(255, 255, 255, 0.9);
            margin-top: 30px;
        }
    }
}
</style>
