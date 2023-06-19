<template>
    <Guest>
        <div class="course-section">
            <div class="banner">
                <div class="container-x">
                    <div>
                        <h2>Archives: Courses</h2>
                    </div>
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol
                            class="inline-flex items-center space-x-1 md:space-x-3"
                        >
                            <li class="inline-flex items-center">
                                <router-link
                                    to="/"
                                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                                >
                                    <i class="fa fa-home mr-3"></i>
                                    Home
                                </router-link>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fa fa-angle-right"></i>
                                    <span
                                        class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                                        v-text="'Courses'"
                                    ></span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-10">
                <div class="container-x">
                    <div class="flex justify-between items-center my-3">
                        <span>Showing 1 - 1 OF 1 Results</span>
                        <div>
                            <input
                                type="search"
                                class="block w-full sm:w-64 px-3 py-3 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-theme-500 focus:border-theme-500 text-sm"
                            />
                        </div>
                    </div>

                    <div
                        v-if="results.records.length && !results.loading"
                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4"
                    >
                        <course-card
                            v-for="course in results.records"
                            :key="course.id"
                            :course="course"
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
                <br />
                <Pager
                    v-if="lastPage && !results.loading"
                    :page-count="lastPage"
                    :value="currentPage"
                    @input="onPagerInput"
                />
            </div>
        </div>
        <!-- Meet Out Pastors -->
    </Guest>
</template>

<script>
import { watch, onMounted, reactive, computed } from "vue";
import CourseService from "@/services/CourseService";
import Guest from "@/views/layouts/Guest";
import AppDownload from "@/views/components/AppDownload";
import Pager from "@/views/components/Pager";
import { getResponseError, prepareQuery } from "@/helpers/api";
import { trans } from "@/helpers/i18n";
import Spinner from "@/views/components/icons/Spinner";

export default {
    components: {
        Guest,
        AppDownload,
        Pager,
        Spinner,
    },
    setup() {
        const service = new CourseService();

        const results = reactive({
            records: [],
            loading: false,
            pagination: {
                meta: null,
                links: null,
            },
        });
        const mainQuery = reactive({
            page: 1,
            search: "",
            sort: "",
            filters: {},
        });

        function fetchPage(params) {
            results.records = [];
            results.loading = true;
            let query = prepareQuery(params);
            service
                .getCourses(query)
                .then((response) => {
                    results.records = response.data.data;
                    results.pagination.meta = response.data.meta;
                    results.pagination.links = response.data.links;
                    results.loading = false;
                })
                .catch((error) => {
                    // alertStore.error(getResponseError(error));
                    results.loading = false;
                });
        }

        watch(mainQuery, (newTableState) => {
            fetchPage(mainQuery);
        });

        onMounted(() => {
            fetchPage(mainQuery);
        });

        function getPaginationMeta(key) {
            let value = null;
            if (results.pagination) {
                if (
                    results.pagination.hasOwnProperty("meta") &&
                    results.pagination.meta
                ) {
                    if (results.pagination.meta.hasOwnProperty(key)) {
                        value = results.pagination.meta[key];
                    }
                }
            }
            return value;
        }

        function onPagerInput(page) {
            mainQuery.page = page;
        }

        const currentPage = computed(() => {
            return getPaginationMeta("current_page");
        });
        const lastPage = computed(() => {
            return getPaginationMeta("last_page");
        });

        return {
            results,
            trans,
            currentPage,
            lastPage,
            onPagerInput,
        };
    },
};
</script>

<style lang="scss" scoped>
.banner {
    padding-top: 60px;
    padding-bottom: 60px;
    background: #d7e5ff;
    position: relative;
    text-align: left;

    h2 {
        margin: 0 0 5px 0;
        font-size: 40px;
        font-weight: 700;
        line-height: 1.4;
        color: var(--color-heading);
    }
}

@media (max-width: 640px) {
    .banner {
        h2 {
            font-size: 24px;
        }
    }
}
</style>
