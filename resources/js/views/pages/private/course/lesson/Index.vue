<template>
    <Page
        :title="page.title"
        :breadcrumbs="page.breadcrumbs"
        :actions="page.actions"
        @action="onPageAction"
    >
        <template #default>
            <Table
                :id="page.id"
                v-if="table"
                :headers="table.headers"
                :sorting="table.sorting"
                :actions="table.actions"
                :records="table.records"
                :pagination="table.pagination"
                :is-loading="table.loading"
                @page-changed="onTablePageChange"
                @action="onTableAction"
                @sort="onTableSort"
            >
                <template v-slot:content-id="props">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <img
                                v-if="props.item.preview_url"
                                :src="props.item.preview_url"
                                class="h-10 w-10 rounded"
                                alt=""
                            />
                            <div
                                v-else
                                class="h-10 w-10 rounded bg-theme-100"
                            ></div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm text-gray-500">
                                {{
                                    trans("users.labels.id") +
                                    ": " +
                                    props.item.id
                                }}
                            </div>
                        </div>
                    </div>
                </template>
                <template v-slot:content-status="props">
                    <span
                        v-if="props.item.published"
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                        v-html="trans('Live')"
                    ></span>
                    <span
                        v-else
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800"
                        v-html="trans('Draft')"
                    ></span>
                </template>
                <template v-slot:content-createdAt="props">
                    <span>{{ props.item.created_at }}</span>
                </template>

                <template v-slot:content-question="props">
                    <Button
                        :to="{
                            name: 'course.lesson.question.list',
                            params: {
                                id: props.item.id,
                                courseId: props.item.course_id,
                            },
                        }"
                        size="sm"
                        v-if="props.item.content_type === 'quiz'"
                        label="Questions"
                    />
                </template>
            </Table>
        </template>
    </Page>
</template>

<script>
import { trans } from "@/helpers/i18n";
import CourseService from "@/services/CourseService";
import { watch, onMounted, defineComponent, reactive, ref } from "vue";
import { getResponseError, prepareQuery } from "@/helpers/api";
import { toUrl } from "@/helpers/routing";
import { useAlertStore } from "@/stores";
import alertHelpers from "@/helpers/alert";
import Page from "@/views/layouts/Page";
import Table from "@/views/components/Table";
import Avatar from "@/views/components/icons/Avatar";
import Filters from "@/views/components/filters/Filters";
import FiltersRow from "@/views/components/filters/FiltersRow";
import FiltersCol from "@/views/components/filters/FiltersCol";
import TextInput from "@/views/components/input/TextInput";
import Dropdown from "@/views/components/input/Dropdown";
import { useRoute } from "vue-router";

export default defineComponent({
    components: {
        Dropdown,
        TextInput,
        FiltersCol,
        FiltersRow,
        Filters,
        Page,
        Table,
        Avatar,
    },
    setup() {
        const service = new CourseService();
        const alertStore = useAlertStore();
        const route = useRoute();
        const mainQuery = reactive({
            page: 1,
            search: "",
            sort: "",
            filters: {
                first_name: {
                    value: "",
                    comparison: "=",
                },
                last_name: {
                    value: "",
                    comparison: "=",
                },
                role: {
                    value: "",
                    comparison: "=",
                },
                email: {
                    value: "",
                    comparison: "=",
                },
            },
        });

        const page = reactive({
            id: "list_lessons",
            title: "Lessons",
            breadcrumbs: [
                {
                    name: "Courses",
                    to: toUrl("/course/list"),
                },
                {
                    name: "Lessons",
                    active: true,
                },
            ],
            actions: [
                {
                    id: "filters",
                    name: trans("global.buttons.filters"),
                    icon: "fa fa-filter",
                    theme: "outline",
                },
                {
                    id: "new",
                    name: trans("global.buttons.add_new"),
                    icon: "fa fa-plus",
                    to: toUrl(`/course/${route.params.id}/lesson/create`),
                },
            ],
            toggleFilters: false,
        });

        const table = reactive({
            headers: {
                id: trans("users.labels.id_pound"),
                sortOrder: "Sort Order",
                title: "Title",
                content_type: "Content Type",
                createdAt: "Created At",
                question: "Question",
            },
            sorting: {
                title: true,
            },
            pagination: {
                meta: null,
                links: null,
            },
            actions: {
                edit: {
                    id: "edit",
                    name: trans("global.actions.edit"),
                    icon: "fa fa-edit",
                    showName: false,
                    to: toUrl("/users/{id}/edit"),
                },
                delete: {
                    id: "delete",
                    name: trans("global.actions.delete"),
                    icon: "fa fa-trash",
                    showName: false,
                    danger: true,
                },
            },
            loading: false,
            records: null,
        });

        function onTableSort(params) {
            mainQuery.sort = params;
        }

        function onTablePageChange(page) {
            mainQuery.page = page;
        }

        function onTableAction(params) {
            switch (params.action.id) {
                case "delete":
                    alertHelpers.confirmDanger(function () {
                        service
                            .delete(params.item.id)
                            .then(function (response) {
                                fetchPage(mainQuery);
                            });
                    });
                    break;
            }
        }

        function onPageAction(params) {
            switch (params.action.id) {
                case "filters":
                    page.toggleFilters = !page.toggleFilters;
                    break;
            }
        }

        function onFiltersClear() {
            let clonedFilters = mainQuery.filters;
            for (let key in clonedFilters) {
                clonedFilters[key].value = "";
            }
            mainQuery.filters = clonedFilters;
        }

        function fetchPage(params) {
            table.records = [];
            table.loading = true;
            let query = prepareQuery(params);
            service
                .getLessons(query, route.params.id)
                .then((response) => {
                    table.records = response.data.data;
                    table.pagination.meta = response.data.meta;
                    table.pagination.links = response.data.links;
                    table.loading = false;
                })
                .catch((error) => {
                    alertStore.error(getResponseError(error));
                    table.loading = false;
                });
        }

        watch(mainQuery, (newTableState) => {
            fetchPage(mainQuery);
        });

        onMounted(() => {
            fetchPage(mainQuery);
        });

        return {
            trans,
            page,
            table,
            onTablePageChange,
            onTableAction,
            onTableSort,
            onPageAction,
            onFiltersClear,
            mainQuery,
        };
    },
});
</script>
