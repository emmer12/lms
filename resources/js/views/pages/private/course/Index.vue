<template>
    <Page
        :title="page.title"
        :breadcrumbs="page.breadcrumbs"
        :actions="page.actions"
        @action="onPageAction"
    >
        <template #filters v-if="page.toggleFilters">
            <Filters @clear="onFiltersClear">
                <FiltersRow>
                    <FiltersCol>
                        <TextInput
                            name="first_name"
                            :label="trans('users.labels.first_name')"
                            v-model="mainQuery.filters.first_name.value"
                        ></TextInput>
                    </FiltersCol>
                    <FiltersCol>
                        <TextInput
                            name="last_name"
                            :label="trans('users.labels.last_name')"
                            v-model="mainQuery.filters.last_name.value"
                        ></TextInput>
                    </FiltersCol>
                    <FiltersCol>
                        <TextInput
                            name="email"
                            type="email"
                            :label="trans('users.labels.email')"
                            v-model="mainQuery.filters.email.value"
                        ></TextInput>
                    </FiltersCol>
                    <FiltersCol>
                        <Dropdown
                            name="role"
                            server="roles/search"
                            :multiple="true"
                            :label="trans('users.labels.role')"
                            v-model="mainQuery.filters.role.value"
                        ></Dropdown>
                    </FiltersCol>
                </FiltersRow>
            </Filters>
        </template>

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
            id: "list_courses",
            title: "Courses",
            breadcrumbs: [
                {
                    name: "Courses",
                    to: toUrl("/course"),
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
                    to: toUrl("/course/create"),
                },
            ],
            toggleFilters: false,
        });

        const table = reactive({
            headers: {
                id: trans("users.labels.id_pound"),
                title: "Title",
                price: "Price",
                featured: "Featured",
                status: "Status",
                createdAt: "Created At",
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
                    to: toUrl("/course/{id}/edit"),
                },
                lesson: {
                    id: "lesson",
                    name: trans("Add Lessons"),
                    icon: "fa fa-plus",
                    showName: false,
                    to: toUrl("/course/{id}/lesson/create"),
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
                .getAllCourse(query)
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
