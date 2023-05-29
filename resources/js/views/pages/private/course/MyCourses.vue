<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs">
        <template #default>
            <div
                v-if="results.courses.length && !results.loading"
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4"
            >
                <CourseCard
                    v-for="course in results.courses"
                    :key="course.id"
                    :course="course"
                />
            </div>
            <div v-else>
                <template v-if="results.loading">
                    <Spinner :text-new-line="true"></Spinner>
                </template>
                <template v-else>
                    <div class="mb-5">
                        {{ trans("global.phrases.no_records") }}
                    </div>

                    <Button
                        label="Enroll for Courses"
                        size="sm"
                        to="/courses"
                    />
                </template>
            </div>
        </template>
    </Page>
</template>

<script>
import CourseCard from "@/views/components/card/CourseCard3.vue";
import { onMounted, reactive } from "vue";
import { getResponseError, prepareQuery } from "@/helpers/api";
import CourseService from "@/services/CourseService";
import { toUrl } from "@/helpers/routing";
import { trans } from "@/helpers/i18n";
import Page from "@/views/layouts/Page";
import Spinner from "@/views/components/icons/Spinner";
import { useAlertStore } from "@/stores";

export default {
    components: {
        CourseCard,
        Page,
        Spinner,
    },
    setup() {
        const service = new CourseService();
        const alertStore = useAlertStore();

        const page = reactive({
            id: "list_course_list",
            title: "My Courses",
            breadcrumbs: [
                {
                    name: "My Courses",
                    to: toUrl("/my-course"),
                    active: true,
                },
            ],
        });

        const mainQuery = reactive({
            page: 1,
            search: "",
            sort: "",
        });

        const results = reactive({
            courses: [],
            loading: false,
            pagination: {
                meta: null,
                links: null,
            },
        });

        function fetchPage(params) {
            results.records = [];
            results.loading = true;
            let query = prepareQuery(params);
            service
                .getMyCourse(query)
                .then((response) => {
                    console.log(response.data.data);
                    results.courses = response.data.data;
                    results.pagination.meta = response.data.meta;
                    results.pagination.links = response.data.links;
                    results.loading = false;
                })
                .catch((error) => {
                    alertStore.error(getResponseError(error));
                    results.loading = false;
                });
        }

        onMounted(() => {
            fetchPage(mainQuery);
        });

        return {
            page,
            results,
            trans,
        };
    },
};
</script>

<style></style>
