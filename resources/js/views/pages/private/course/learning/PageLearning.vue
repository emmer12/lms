<template>
    <div class="h-full">
        <template v-if="results.fetching">
            <div class="flex items-center justify-center">
                <Spinner :text-new-line="false"></Spinner>
            </div>
        </template>
        <div class="h-full" v-else>
            <div v-if="currentLesson?.content_type == 'quiz'">
                <QuizComponent
                    :questions="results?.questions"
                    :course_id="currentLesson?.course_id"
                    :lesson_id="currentLesson?.id"
                    :duration="currentLesson?.quiz_duration"
                    :currentLesson="currentLesson"
                    @next="next"
                />
            </div>
            <div class="content-con flex flex-col h-full" v-else>
                <div class="flex-1">
                    <div class="overview">
                        <h2 class="headings">
                            {{ currentLesson?.title }}
                        </h2>

                        <div v-if="currentLesson?.materials">
                            <h4>Course Materials</h4>
                            <MaterialList
                                v-for="material in currentLesson?.materials"
                                :key="material.id"
                                :material="material"
                            />
                        </div>
                    </div>
                    <div
                        class="ck"
                        v-if="currentLesson"
                        v-html="currentLesson?.description"
                    ></div>
                    <div
                        class="ck"
                        v-if="currentLesson?.content_type == 'article'"
                        v-html="currentLesson?.article_body"
                    ></div>
                </div>

                <div
                    v-if="currentLesson?.content_type !== 'quiz'"
                    class="action flex items-center justify-between b-0"
                >
                    <Button
                        size="sm"
                        label="Prev"
                        @click="prev"
                        icon="fa fa-angle-left"
                    />
                    <Button
                        v-if="
                            results.next_id &&
                            !results.completed.includes(results.lesson.id)
                        "
                        size="sm"
                        @click="completed"
                        label="Mark As Completed"
                        :disabled="results.loading"
                    />
                    <Button
                        v-if="
                            results?.completed.includes(results?.lesson?.id) &&
                            results?.lessons[results?.lessons.length - 1].id !==
                                results?.lesson?.id
                        "
                        :disabled="!results.completed_prev"
                        @click="next"
                        size="sm"
                        label="Next"
                        iconRight="fa fa-angle-right"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MaterialList from "@/views/components/MaterialList.vue";
import Times from "@/views/components/icons/Times";
import CourseService from "@/services/CourseService";
import { watch, onMounted, reactive, ref, getCurrentInstance } from "vue";
import { trans } from "@/helpers/i18n";
import { useRoute, useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useAlertStore } from "@/stores/alert";
import Spinner from "@/views/components/icons/Spinner";
import QuizComponent from "@/views/components/QuizComponent";
import { useBus } from "@/hooks";

export default {
    components: {
        Times,
        Spinner,
        MaterialList,
        QuizComponent,
    },
    setup() {
        const service = new CourseService();
        const authStore = useAuthStore();
        const route = useRoute();
        const router = useRouter();
        const { bus } = useBus();
        const app = getCurrentInstance();
        const $confirm = app.appContext.config.globalProperties.$confirm;

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

        function fetchPage(params = { lesson_id: route.params.lesson_id }) {
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
                    currentLesson.value = response.data.lesson;
                })
                .catch((error) => {
                    results.fetching = false;
                    results.loading = false;
                });
        }

        watch(
            () => route.params.lesson_id,
            (lesson_id) => {
                fetchPage({ lesson_id: lesson_id });
            }
        );

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

        const completed = async () => {
            $confirm({
                message: "Do You wish to go to the next lesson?",
                button: {
                    no: "No",
                    yes: "Yes",
                },
                /**
                 * Callback Function
                 * @param {Boolean} confirm
                 */
                callback: (confirm) => {
                    if (confirm) {
                        processCom(true);
                    } else {
                        processCom(false);
                    }
                },
            });
            results.loading = true;
        };

        const processCom = async (redirect) => {
            try {
                await service.markCompleted(currentLesson.value.id);
                fetchPage({ lesson_id: route.params.lesson_id });
                results.loading = false;
                bus.emit("lesson_completed");
                if (!redirect) return;
                next(true);
            } catch {
                results.loading = false;
            }
        };

        const close = () => {
            router.push("/panel/my-courses");
        };

        const next = (auto = false) => {
            const { currentIndex, lesson_ids } = getCurrentIndex();
            if (!results.completed_prev && !auto) return;

            router.push({
                name: "my.learning.lesson",
                params: { lesson_id: lesson_ids[currentIndex + 1] },
            });
        };

        const prev = () => {
            const { currentIndex, lesson_ids } = getCurrentIndex();
            if (currentIndex == 0) return;
            router.push({
                name: "my.learning.lesson",
                params: { lesson_id: lesson_ids[currentIndex - 1] },
            });
        };

        const getCurrentIndex = () => {
            const lesson_ids = results.lessons.map((lesson) => lesson.id);
            const currentIndex = lesson_ids.findIndex(
                (val) => val == results.lesson.id
            );
            return { currentIndex, lesson_ids };
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
            completed,
            next,
            prev,
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

            .overview {
                .headings {
                    font-size: 24px;
                    font-weight: 700;
                    margin: 15px 0px;
                }

                h4 {
                    font-size: 18px;
                    font-weight: 500;
                }
            }
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

@media (max-width: 640px) {
}
</style>
