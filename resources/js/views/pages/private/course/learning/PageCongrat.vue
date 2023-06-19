<template>
    <div>
        <div class="congrat h-screen bg-theme-600 flex">
            <div class="wrapper">
                <img src="/assets/images/congrat.png" />
                <h2>Congratulations</h2>
                <p>You did a good job in tests and exam!</p>
                <br />

                <Button
                    label="Download Certificate"
                    @click="download"
                    :disabled="downloading"
                />
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
        const route = useRoute();
        const downloading = ref(false);
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

                    if (
                        !results?.course_progress?.pivot?.certificate_eligible
                    ) {
                        router.back();
                    }

                    if (hasVal) {
                        currentLesson.value = response.data.lesson;
                    }
                })
                .catch((error) => {
                    router.push("/");
                    results.fetching = false;
                    results.loading = false;
                });
        }

        const download = async () => {
            const course_id = route.params.id;

            downloading.value = true;
            try {
                await service.downloadCertificate(course_id);
                downloading.value = false;
            } catch (err) {
                downloading.value = false;
            }
        };

        onMounted(() => {
            fetchPage();
        });

        return {
            results,
            trans,
            authStore,
            currentLesson,
            open,
            setOpen,
            download,
            downloading,
        };
    },
};
</script>

<style scoped lang="scss">
.congrat {
    position: relative;

    .wrapper {
        width: 620px;
        max-width: 90%;
        border-radius: 20px;
        padding: 20px;
        background: #fff;
        margin: 50px auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-bottom: 30px;
        text-align: center;

        img {
            width: 70%;
        }

        p {
            font-size: 20px;
        }

        h2 {
            font-size: 40px;
            font-weight: 800;
        }
    }
}

@media (max-width: 640px) {
    .congrat {
        .wrapper {
            p {
                font-size: 18px;
            }

            h2 {
                font-size: 24px;
            }
        }
    }
}
</style>
