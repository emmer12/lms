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
                <div class="top flex">
                    <div class="flex items-center w-full p-5 gap-3">
                        <input
                            placeholder="Search Course content"
                            type="search"
                            class="s-input flex-1 bg-transparent"
                        />
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
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                            />
                        </svg>
                    </div>
                </div>
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
                        <LessonList
                            :lesson="lesson"
                            type="certificate"
                            :certificate_eligible="
                                results?.course_progress?.pivot
                                    ?.certificate_eligible
                            "
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
                <div
                    class="course-overview"
                    v-if="$route.name == 'my.learning'"
                >
                    <div class="ck" v-html="results?.course?.description"></div>
                    <div
                        class="p-4 bg-theme-100 rounded-xl"
                        v-if="
                            results?.course_progress?.pivot
                                ?.certificate_eligible
                        "
                    >
                        <span class="block text-theme-800 mb-5">
                            Congratulations! You have completed this
                            course.</span
                        >

                        <Button
                            label="Download Certificate"
                            size="sm"
                            :to="{
                                name: 'my.course.congratulations',
                                params: { id: results.course.id },
                            }"
                        />
                    </div>
                    <div v-else>
                        <Button
                            size="md"
                            @click="next(results.next_id)"
                            :label="
                                results.completed.length
                                    ? 'Continue'
                                    : 'Start Now'
                            "
                            v-if="!results.loading"
                        />
                    </div>
                </div>
                <router-view></router-view>
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
import { useBus } from "@/hooks";

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
        const { bus } = useBus();
        const results = reactive({
            course: null,
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
                    results.course_progress = response.data.course_progress;
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

        // const isMobile = () => {
        //     let check = false;
        //     (function (a) {
        //         if (
        //             /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(
        //                 a
        //             ) ||
        //             /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
        //                 a.substr(0, 4)
        //             )
        //         )
        //             check = true;
        //     })(navigator.userAgent || navigator.vendor || window.opera);
        //     return check;
        // };

        const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

        watch(route, (newTableState) => {
            if (isMobile) {
                open.value = false;
            }
        });

        onMounted(() => {
            fetchPage();

            if (isMobile) {
                open.value = false;
            }

            bus.on("lesson_completed", () => {
                fetchPage();
            });
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

        const next = (index) => {
            router.push({
                name: "my.learning.lesson",
                params: { lesson_id: index },
            });
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
            next,
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

            input {
                border: none;
                outline: none;
            }
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
        padding-left: 50px;
        background: #fff;
        padding-right: 15px;
        height: calc(100vh - 70px);

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

@media (max-width: 640px) {
    .learning-wrapper {
        .main {
            margin: 50px 0px 20px 0px;
            padding: 10px;
            padding-left: 15px;
        }

        .sidebar {
            flex: 0 0 95%;
        }
        .toggle {
            left: 90%;
        }
    }
}
</style>
