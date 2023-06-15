<template>
    <div>
        <h1 class="text-2xl mb-4 font-bold text-gray-600">
            Hello {{ authStore.user.full_name }}
        </h1>

        <div class="course">
            <!-- <pre> {{ authStore.user }}</pre> -->
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="bg-white w-full sm:w-1/2 p-3 rounded-[20px]">
                    <div class="p-3">
                        <div class="flex justify-between">
                            <h4 class="font-bold text-xl">Your Courses</h4>
                            <router-link
                                class="font-bold text-theme-700"
                                :to="{ name: 'my.courses' }"
                                >View All</router-link
                            >
                        </div>

                        <div
                            v-if="results.courses.length && !results.loading"
                            class=""
                        >
                            <CourseCard4
                                v-for="course in results.courses"
                                :course="course"
                                :key="course.id"
                            />
                        </div>

                        <div v-else>
                            <template v-if="results.loading">
                                <Spinner :text-new-line="true"></Spinner>
                            </template>
                            <template v-else>
                                {{ trans("global.phrases.no_records") }}
                            </template>
                        </div>
                    </div>
                </div>
                <div class="bg-white w-full sm:w-1/2 p-3 rounded-[20px]">
                    <div class="inner">
                        <div class="display rounded-full">
                            <img
                                v-if="authStore.user.avatar_url"
                                :src="authStore.user.avatar_url"
                                alt="Avatar"
                            />
                            <img
                                v-else
                                :src="`https://eu.ui-avatars.com/api/?name=${authStore.user.full_name}&size=50`"
                                alt="Avatar"
                            />
                        </div>
                        <div class="details text-center my-3">
                            <h4 class="text-xl font-semibold">
                                {{ authStore.user.full_name }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, onMounted, reactive } from "vue";
import { trans } from "@/helpers/i18n";
import Page from "@/views/layouts/Page";

import { useAuthStore } from "@/stores/auth";
import CourseService from "@/services/CourseService";

export default defineComponent({
    components: {
        Page,
    },
    setup() {
        const authStore = useAuthStore();
        const service = new CourseService();

        const results = reactive({
            courses: [],
            certificates: null,
            loading: false,
        });

        function getPageData() {
            service
                .getUserDashboardData()
                .then((response) => {
                    results.courses = response.data.courses;
                    results.certificate = response.data.certificates;
                    results.loading = false;
                })
                .catch((error) => {
                    results.loading = false;
                });
        }

        onMounted(() => {
            getPageData();
        });

        return {
            trans,
            authStore,
            results,
        };
    },
});
</script>

<style lang="scss" scoped>
.course {
    .display {
        height: 120px;
        width: 120px;
        margin: auto;

        img {
            height: 100%;
            width: 100%;
            border-radius: 50%;
        }
    }
}
</style>
