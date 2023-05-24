<template>
    <div>
        <div class="learning-wrapper flex">
            <div
                class="header flex justify-between relative"
                :class="{ closed: !open }"
            >
                <h2 class="text-white font-bold text-lg">
                    {{ results?.course?.title }}
                </h2>
                <div class="flex items-center">
                    <div class="absolute right-11 mt-2">
                        <template v-if="results.fetching">
                            <Spinner :text-new-line="false"></Spinner>
                        </template>
                    </div>
                    <h4 @click="close()" class="cursor-pointer"><Times /></h4>
                </div>
            </div>
            <div class="toggle" :class="{ closed: !open }" @click="setOpen">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 19.5L8.25 12l7.5-7.5"
                    />
                </svg>
            </div>
            <div class="sidebar" :class="{ closed: !open }">
                <div class="top"></div>
                <div class="body">
                    <div v-if="results.lessons.length && !results.loading">
                        <LessonList
                            v-for="(lesson, index) in results.lessons"
                            :key="lesson.id"
                            :lesson="lesson"
                            :index="index"
                            @selected="handleSelect"
                            :completed="results.completed"
                            :next_id="results.next_id"
                            :currentLesson="currentLesson"
                        />
                    </div>
                    <div v-else>
                        <template v-if="results.loading">
                            <div class="flex items-center justify-center">
                                <Spinner :text-new-line="true"></Spinner>
                            </div>
                        </template>
                        <template v-else>
                            <span class="p-4">{{
                                trans("global.phrases.no_records")
                            }}</span>
                        </template>
                    </div>
                </div>
            </div>
            <div class="main">
                <div v-if="currentLesson?.content_type == 'quiz'">
                    <QuizComponent
                        :questions="results?.questions"
                        :course_id="currentLesson?.course_id"
                        :lesson_id="currentLesson?.id"
                        :duration="currentLesson?.quiz_duration"
                    />
                </div>
                <div class="content-con">
                    <div
                        v-if="currentLesson"
                        v-html="currentLesson.description"
                    ></div>
                    <div v-else v-html="results?.course?.description"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LessonList from "@/views/components/LessonList.vue";
import Times from "@/views/components/icons/Times";
import CourseService from "@/services/CourseService";
import { watch, onMounted, reactive, ref } from "vue";
import { trans } from "@/helpers/i18n";
import { useRoute, useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useAlertStore } from "@/stores/alert";
import Spinner from "@/views/components/icons/Spinner";
import QuizComponent from "@/views/components/QuizComponent";

export default {
    components: {
        LessonList,
        Times,
        Spinner,
        QuizComponent,
    },
    setup() {
        const service = new CourseService();
        const authStore = useAuthStore();
        const alertStore = useAlertStore();
        const route = useRoute();
        const router = useRouter();
        const results = reactive({
            courses: null,
            lesson: null,
            lessons: [],
            completed: [],
            completed_prev: false,
            prev_id: 0,
            loading: false,
            fetching: false,
        });

        const currentLesson = ref(null);
        const open = ref(true);

        function setOpen() {
            open.value = !open.value;
        }
        const mainQuery = reactive({
            lesson_id: 1,
        });

        function fetchPage(params = {}) {
            results.record = null;
            results.fetching = true;

            const hasVal = Object.values(params).length;
            if (!hasVal) {
                results.loading = true;
            }
            service
                .getCourseLessons(route.params.id, params)
                .then((response) => {
                    results.course = response.data.course;
                    results.lessons = response.data.lessons;
                    results.lesson = response.data.lesson;
                    results.completed = response.data.completed_lessons;
                    results.completed_prev = response.data.completed_prev;
                    results.questions = response.data.questions;
                    results.next_id = response.data.next_id;
                    results.loading = false;
                    results.fetching = false;

                    if (hasVal) {
                        currentLesson.value = response.data.lesson;
                    }
                })
                .catch((error) => {
                    results.fetching = false;
                    results.loading = false;
                });
        }

        watch(mainQuery, (newTableState) => {
            fetchPage(mainQuery);
        });

        onMounted(() => {
            fetchPage();
        });

        function setActive(val) {
            activeTab.value = val;
        }

        function handleSelect(id) {
            if (id == results?.lesson?.id) {
                currentLesson.value = results.lesson;
            } else {
                mainQuery.lesson_id = id;
            }
        }

        const close = () => {
            router.push("/panel/my-courses");
        };

        return {
            results,
            trans,
            setActive,
            authStore,
            handleSelect,
            currentLesson,
            open,
            setOpen,
            close,
        };
    },
};
</script>

<style scoped lang="scss">
.learning-wrapper {
    position: relative;
    .header {
        display: flex;
        position: fixed;
        z-index: 100;
        right: 0;
        left: 475px;
        padding: 0px 15px;
        border-bottom: 1px solid #d9e0f1;
        background: #456acb;
        -webkit-transition: left 0.25s;
        -moz-transition: left 0.25s;
        -ms-transition: left 0.25s;
        -o-transition: left 0.25s;
        transition: left 0.25s;
        height: 70px;
        color: #fff;
        align-items: center;

        &.closed {
            left: 0px;
        }
    }
    .sidebar {
        overflow: auto;
        position: relative;
        box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.1);
        flex: 0 0 475px;
        height: 100svh;
        transition: 0.25s;

        &.closed {
            flex: 0 0 0px;
        }

        .top {
            height: 100px;
        }

        .body {
            background: #fff;
            padding: 15px 0px;
            height: calc(100vh - 150px);
            overflow: auto;
        }
    }

    .main {
        overflow: auto;
        position: relative;
        margin: 70px 0px 50px 0px;
        flex: 1;
        padding: 10px;
        padding-left: 15px;
        background: #fff;
        padding-right: 15px;

        .content-con {
            width: 640px;
            max-width: 100%;
            margin: auto;
        }
    }

    .toggle {
        display: flex;
        align-items: center;
        position: absolute;
        z-index: 100;
        top: 198px;
        left: 475px;
        width: 25px;
        height: 56px;
        margin: 0;
        background: #fff;
        box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.15);
        cursor: pointer;
        transition: 0.25s;
        -webkit-appearance: none;
        border: 0;
        svg {
            transition: 0.5s;
        }

        &.closed {
            left: 0px;

            svg {
                rotate: 180deg;
            }
        }
    }
}
</style>
