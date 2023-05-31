<template>
    <Guest>
        <div class="course-section bg-white">
            <div class="banner">
                <div class="container-x">
                    <div>
                        <h2>{{ results?.record?.title }}</h2>
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
                                <i class="fa fa-angle-right mx-1"></i>
                            </li>
                            <li class="inline-flex items-center">
                                <router-link
                                    to="/courses"
                                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                                >
                                    <i class="fa fa-book mr-3"></i>
                                    courses
                                </router-link>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fa fa-angle-right"></i>
                                    <span
                                        class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                                        v-text="results?.record?.title"
                                    ></span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-2 pb-10">
                <div class="container-x">
                    <div
                        class="flex flex-col sm:flex-row gap-10 course-details"
                    >
                        <div class="flex-1">
                            <div class="title mb-4">
                                <h2>
                                    {{ results?.record?.title }}
                                </h2>
                            </div>

                            <div class="tabs">
                                <div
                                    class="tab"
                                    :class="{ active: activeTab == 1 }"
                                >
                                    <label @click="setActive(1)"
                                        >Overview</label
                                    >
                                </div>
                                <div
                                    class="tab"
                                    :class="{ active: activeTab == 2 }"
                                >
                                    <label @click="setActive(2)"
                                        >Curriculum</label
                                    >
                                </div>
                                <div
                                    class="tab"
                                    :class="{ active: activeTab == 3 }"
                                >
                                    <label @click="setActive(3)"
                                        >Instructor</label
                                    >
                                </div>
                            </div>

                            <div class="tabs-body">
                                <div v-if="activeTab == 1">
                                    <div
                                        class="ck"
                                        v-html="results?.record?.description"
                                    ></div>
                                </div>
                                <div v-if="activeTab == 2">
                                    <div class="course-lists">
                                        <div
                                            class="list"
                                            v-for="lesson in results?.record
                                                ?.lessons"
                                            :key="lesson.id"
                                        >
                                            <div
                                                class="flex gap-3 items-center"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-file-text"
                                                >
                                                    <path
                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                                                    ></path>
                                                    <polyline
                                                        points="14 2 14 8 20 8"
                                                    ></polyline>
                                                    <line
                                                        x1="16"
                                                        y1="13"
                                                        x2="8"
                                                        y2="13"
                                                    ></line>
                                                    <line
                                                        x1="16"
                                                        y1="17"
                                                        x2="8"
                                                        y2="17"
                                                    ></line>
                                                    <polyline
                                                        points="10 9 9 9 8 9"
                                                    ></polyline>
                                                </svg>
                                                <span>{{ lesson.title }}</span>
                                            </div>

                                            <div>
                                                <div v-if="lesson.is_preview">
                                                    <Button
                                                        label="Preview"
                                                        size="xs"
                                                    />
                                                </div>
                                                <div v-else>
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="20"
                                                        height="20"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-lock"
                                                    >
                                                        <rect
                                                            x="3"
                                                            y="11"
                                                            width="18"
                                                            height="11"
                                                            rx="2"
                                                            ry="2"
                                                        ></rect>
                                                        <path
                                                            d="M7 11V7a5 5 0 0 1 10 0v4"
                                                        ></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="activeTab == 3"></div>
                            </div>
                        </div>
                        <div class="side-con">
                            <div class="side">
                                <div class="list-value flex justify-between">
                                    <div class="flex items-center gap-3">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#456acb"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-clock"
                                        >
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="10"
                                            ></circle>
                                            <polyline
                                                points="12 6 12 12 16 14"
                                            ></polyline>
                                        </svg>
                                        <span>Duration</span>
                                    </div>
                                    <span>17 Weeks</span>
                                </div>

                                <div class="list-value flex justify-between">
                                    <div class="flex items-center gap-3">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#456acb"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-users"
                                        >
                                            <path
                                                d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"
                                            ></path>
                                            <circle
                                                cx="9"
                                                cy="7"
                                                r="4"
                                            ></circle>
                                            <path
                                                d="M23 21v-2a4 4 0 0 0-3-3.87"
                                            ></path>
                                            <path
                                                d="M16 3.13a4 4 0 0 1 0 7.75"
                                            ></path>
                                        </svg>
                                        <span>Students</span>
                                    </div>
                                    <span>17</span>
                                </div>

                                <div class="list-value flex justify-between">
                                    <div class="flex items-center gap-3">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#456acb"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-file-text"
                                        >
                                            <path
                                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                                            ></path>
                                            <polyline
                                                points="14 2 14 8 20 8"
                                            ></polyline>
                                            <line
                                                x1="16"
                                                y1="13"
                                                x2="8"
                                                y2="13"
                                            ></line>
                                            <line
                                                x1="16"
                                                y1="17"
                                                x2="8"
                                                y2="17"
                                            ></line>
                                            <polyline
                                                points="10 9 9 9 8 9"
                                            ></polyline>
                                        </svg>
                                        <span>Lessons</span>
                                    </div>
                                    <span>{{
                                        results?.record?.lessons?.length
                                    }}</span>
                                </div>

                                <div class="list-value flex justify-between">
                                    <div class="flex items-center gap-3">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#456acb"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-clock"
                                        >
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="10"
                                            ></circle>
                                            <polyline
                                                points="12 6 12 12 16 14"
                                            ></polyline>
                                        </svg>
                                        <span>Quizzes</span>
                                    </div>
                                    <span>{{
                                        countQuiz(results?.record?.lessons)
                                    }}</span>
                                </div>

                                <div class="list-value flex justify-between">
                                    <div class="flex items-center gap-3">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#456acb"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-globe"
                                        >
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="10"
                                            ></circle>
                                            <line
                                                x1="2"
                                                y1="12"
                                                x2="22"
                                                y2="12"
                                            ></line>
                                            <path
                                                d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"
                                            ></path>
                                        </svg>

                                        <span>Language</span>
                                    </div>
                                    <span>English</span>
                                </div>

                                <div class="list-value flex justify-between">
                                    <div class="flex items-center gap-3">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#456acb"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-percent"
                                        >
                                            <line
                                                x1="19"
                                                y1="5"
                                                x2="5"
                                                y2="19"
                                            ></line>
                                            <circle
                                                cx="6.5"
                                                cy="6.5"
                                                r="2.5"
                                            ></circle>
                                            <circle
                                                cx="17.5"
                                                cy="17.5"
                                                r="2.5"
                                            ></circle>
                                        </svg>
                                        <span>Pass Percentage </span>
                                    </div>
                                    <span>80%</span>
                                </div>

                                <div class="list-value flex justify-between">
                                    <div class="flex items-center gap-3">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#456acb"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-award"
                                        >
                                            <circle
                                                cx="12"
                                                cy="8"
                                                r="7"
                                            ></circle>
                                            <polyline
                                                points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"
                                            ></polyline>
                                        </svg>

                                        <span>Certifications </span>
                                    </div>
                                    <span>Yes</span>
                                </div>

                                <br />

                                <Button
                                    @click="enroll"
                                    :label="
                                        results?.record?.price == 0
                                            ? 'Enroll for Free'
                                            : 'Enroll'
                                    "
                                    class="block w-full"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Meet Out Pastors -->
    </Guest>
</template>

<script>
import { watch, onMounted, reactive, ref } from "vue";
import CourseService from "@/services/CourseService";
import Guest from "@/views/layouts/Guest";
import AppDownload from "@/views/components/AppDownload";
import Pager from "@/views/components/Pager";
import { trans } from "@/helpers/i18n";
import { useRoute, useRouter } from "vue-router";
import Spinner from "@/views/components/icons/Spinner";
import { useAuthStore } from "@/stores/auth";
import { useAlertStore } from "@/stores/alert";
export default {
    components: {
        Guest,
        AppDownload,
        Pager,
        Spinner,
    },
    setup() {
        const service = new CourseService();
        const activeTab = ref(1);
        const authStore = useAuthStore();
        const alertStore = useAlertStore();
        const route = useRoute();
        const router = useRouter();
        const results = reactive({
            record: null,
            related_courses: [],
            loading: false,
        });
        const mainQuery = reactive({
            page: 1,
            search: "",
            sort: "",
            filters: {},
        });

        function fetchPage(params) {
            results.record = null;
            results.loading = true;
            service
                .getCourse(route.params.slug)
                .then((response) => {
                    results.record = response.data.course;
                    results.related_courses = response.data.related_courses;
                    results.loading = false;
                })
                .catch((error) => {
                    results.loading = false;
                });
        }

        watch(route.params.slug, (newTableState) => {
            fetchPage(mainQuery);
        });

        onMounted(() => {
            fetchPage(mainQuery);
        });

        function setActive(val) {
            activeTab.value = val;
        }

        function countQuiz(lessons) {
            return (
                lessons &&
                lessons.filter((lesson) => lesson.content_type == "quiz").length
            );
        }
        async function enroll() {
            if (authStore.loggedIn) {
                try {
                    await service.handleEnroll({
                        course_id: results.record.id,
                    });
                    alertStore.success("You have successfully enrolled.");
                    router.push(`/my/learning/${results?.record?.id}`);
                } catch (err) {
                    alert("Opps, something went wrong");
                }
            } else {
                alertStore.info(
                    "To proceed with your enrollment, kindly sign in or register."
                );
                localStorage.setItem(
                    "session_enrolling",
                    JSON.stringify({
                        slug: results?.record?.slug,
                    })
                );
                router.push({ name: "login" });
            }
        }

        return {
            results,
            trans,
            activeTab,
            setActive,
            course: results?.record,
            countQuiz,
            enroll,
            authStore,
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

.course-details {
    max-width: 100%;
    margin: auto;

    .title {
        h2 {
            font-weight: 800;
            font-size: 40px;
            line-height: 1.4;
            margin-bottom: 25px;
        }
    }
    .side-con {
        width: 360px;
        max-width: 100%;
        margin-top: -50px;
        position: relative;
        z-index: 100;
        min-height: 400px;

        .side {
            padding: 20px 20px;
            border-radius: 10px;
            background: #ffffff;
            box-shadow: 0px 10px 30px rgb(0 0 0 / 7%);

            .list-value {
                font-weight: 600;
                border-bottom: 1px solid #f5f5f5;
                padding: 15px 10px;
                margin-left: 15px;
            }
        }
    }

    .tabs-body {
        padding: 15px 10px;
    }
    .course-lists {
        .list {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #f5f5f5;
            padding: 15px 10px;
            gap: 10px;
            cursor: pointer;
        }
    }
}

.tabs {
    padding: 15px 10px;
    background: #f5f5f5;
    font-weight: 500;
    display: flex;
    justify-content: space-between;
    margin: 0 !important;
    padding: 0 !important;
    text-align: center;
    border-radius: 10px;

    .tab {
        display: flex;
        flex: 1;
        justify-content: center;
        text-align: center;
        height: 60px;
        align-items: center;

        &.active {
            label {
                color: #456acb;

                &:after {
                    width: 100%;
                    opacity: 1;
                }
            }
        }

        label {
            font-size: 18px;
            font-weight: 600;
            position: relative;
            margin: 0px;
            padding: 0px;

            cursor: pointer;
            height: 100%;
            line-height: 60px;

            &:hover {
                color: #456acb;
            }

            &:after {
                content: "";
                position: absolute;
                width: 0%;
                height: 2px;
                opacity: 0;
                left: 0px;
                bottom: 0px;
                background: #456acb;
                transition: 0.3s;
            }
        }
    }
}

@media (max-width: 640px) {
    .tabs {
        padding: 10px;

        .tab {
            height: 50px;

            label {
                font-size: 14px;
                line-height: 50px;
            }
        }
    }

    .course-details {
        .title {
            h2 {
                font-size: 24px;
            }
        }
    }
    .banner {
        padding-top: 60px;
        padding-bottom: 60px;

        h2 {
            font-size: 24px;
            line-height: 1.4;
        }
    }
}
</style>
