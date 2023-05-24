<template>
    <div class="">
        <div v-if="data.started">
            <div class="quiz-con">
                <div class="header flex justify-between items-center">
                    <div>
                        <strong
                            >Question {{ data.currentIndex + 1 }} of
                            {{ data.total }}</strong
                        >
                    </div>
                    <div class="timer">
                        <VueCountdown
                            :time="duration * 60 * 1000"
                            v-slot="{ hours, minutes, seconds }"
                            @end="handleTimeUp()"
                        >
                            Time Remaining
                            <strong
                                >{{ hours > 0 ? hour + ":" : "" }}
                                {{ minutes }} : {{ seconds }}</strong
                            >
                        </VueCountdown>
                    </div>
                </div>
                <div class="progress mt-4">
                    <div
                        class="w-full bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-700"
                    >
                        <div
                            class="bg-blue-600 h-1.5 rounded-full"
                            :style="`width:${getProgress()}%;transition:0.3s cubic-bezier(0.83, 0, 0.17, 1);`"
                        ></div>
                    </div>
                </div>
                <div class="quiz-body">
                    <div class="question">
                        <div class="desc flex items-center gap-4">
                            <span>{{ data.currentIndex + 1 }}.</span>
                            <h4
                                v-html="questions[data.currentIndex].question"
                            ></h4>
                        </div>
                        <div
                            v-for="option in questions[data.currentIndex]
                                .options"
                            :key="option.id"
                            class="options"
                        >
                            <div class="flex items-center gap-4">
                                <input
                                    type="radio"
                                    :id="'opt-' + option.id"
                                    name="option"
                                    :value="{
                                        choice: option.question_tag,
                                        question:
                                            questions[data.currentIndex].id,
                                    }"
                                    v-model="data.answers[data.currentIndex]"
                                />
                                <span class="capitalize"
                                    >{{ option.question_tag }}.</span
                                >
                                <label
                                    :for="'opt-' + option.id"
                                    v-html="option.description"
                                ></label>
                                <span v-if="option.is_correct">Yes</span>
                            </div>
                        </div>

                        <div class="actions flex gap-4 mt-10">
                            <Button
                                size="sm"
                                label="Prev"
                                :disabled="data.currentIndex == 0"
                                @click="handlePrev()"
                            />
                            <Button
                                size="sm"
                                label="Next"
                                iconRight="fa fa-angle-right"
                                @click="handleNext()"
                                v-if="data.currentIndex + 1 < data.total"
                            />

                            <Button
                                size="sm"
                                label="Submit"
                                iconRight="fa fa-angle-right"
                                @click="handleSubmit()"
                                v-else
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="flex items-center justify-center">
            <div class="text-center">
                <h1>Quiz Information {{ data.started }}</h1>
                <Button
                    :disabled="data.loading"
                    @click="startQuiz()"
                    label="Start"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref, onMounted } from "vue";
import Spinner from "@/views/components/icons/Spinner.vue";
import VueCountdown from "@chenfengyuan/vue-countdown";
import CourseService from "@/services/CourseService";

export default defineComponent({
    components: { VueCountdown },
    emits: ["update:isShowing", "close"],
    props: {
        questions: {
            type: Array,
            default: [],
        },
        course_id: {
            type: Array,
            default: [],
        },
        lesson_id: {
            type: Array,
            default: [],
        },
        duration: {
            type: Number,
        },
    },
    setup(props, { emit }) {
        const service = new CourseService();

        const data = ref({
            total: props.questions.length,
            started: false,
            currentIndex: 0,
            answers: [],
            loading: false,
        });

        function onClose() {
            emit("close");
        }

        const startQuiz = async () => {
            try {
                data.value.loading = true;
                await service.startQuiz(props.course_id, props.lesson_id);
                data.value.loading = false;
                data.value.started = true;
            } catch (err) {
                data.value.loading = false;
            }
        };

        const handleNext = () => {
            data.value.currentIndex++;
        };

        const handlePrev = () => {
            data.value.currentIndex--;
        };

        const handleSubmit = () => {
            const attempt = data.value.answers;

            service.submitQuiz(1, JSON.stringify(attempt));
        };

        const handleTimeUp = () => {
            handleSubmit();
        };

        const getProgress = () => {
            return Math.floor(
                (data.value.currentIndex / (data.value.total - 1)) * 100
            );
        };

        const fetchData = (params = {}) => {};

        onMounted(() => {
            data.value.answers = props.questions.map((q) => {
                return {
                    question: q.id,
                    choice: null,
                };
            });
        });

        return {
            onClose,
            data,
            startQuiz,
            handleNext,
            handlePrev,
            handleSubmit,
            handleTimeUp,
            getProgress,
        };
    },
});
</script>

<style lang="scss" scoped>
.quiz-con {
    max-width: 100%;
    width: 600px;
    margin: auto;
    padding: 20px;

    .quiz-body {
        margin: 50px auto;

        .question {
            .desc {
                font-size: 20px;
                h4 {
                    margin: 10px 0px;
                }
            }

            .options {
                padding: 10px;
                background: #f9fafc;
                margin: 6px 0px;
                border-radius: 3px;

                label {
                    cursor: pointer;
                }
            }
        }
    }

    .timer {
        strong {
            font-size: 2em;
            color: #456acb;
        }
        font-weight: 700;
    }
}
</style>
