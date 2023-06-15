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
                    <h2>Begin your learning journey with us.</h2>
                    <p>
                        Begin your learning journey with us at KingsWord
                        Learning Portal, where knowledge and personal growth
                        await you!
                    </p>

                    <div class="list">
                        <div class="flex my-3 items-center">
                            <confirmed />
                            <p>
                                <strong>Create an Account:</strong> Sign up for
                                a free account on our learning portal. This will
                                give you access to our course materials,
                                discussion forums, and other interactive
                                features.
                            </p>
                        </div>
                        <div class="flex my-3 items-center">
                            <confirmed />
                            <p>
                                <strong>Enroll in Courses:</strong> Select the
                                courses that align with your learning objectives
                                and enroll in them. Our courses are designed to
                                be self-paced, allowing you to learn at a speed
                                that suits your schedule, but must be completed
                                within a specific time frame.
                            </p>
                        </div>
                        <div class="flex my-3 items-center">
                            <confirmed />
                            <p>
                                <strong>Engage with Course Materials</strong>
                                Dive into the course materials, including video
                                lectures, readings, and interactive exercises.
                                Immerse yourself in the knowledge and wisdom
                                shared by our expert instructors.
                            </p>
                        </div>
                    </div>
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
import Confirmed from "@/views/components/icons/Confirmed.vue";

export default defineComponent({
    components: {
        Confirmed,
    },
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
        margin-top: 20px;

        h2 {
            color: #fff;
            font-size: 24px;
            font-weight: 800;
        }

        p {
            color: rgba(255, 255, 255, 0.9);
            margin-top: 30px;
        }
    }
}

.list {
    svg {
        height: 20px;
        width: 20px;
        fill: #fcad03;
        margin-right: 15px;
        flex-shrink: 0;
    }
}
</style>
