<template>
    <div class="">
        <div v-if="data.started">
            <div v-if="data?.quiz?.log.length && !data.retake">
                <div class="results">
                    <div class="con text-center">
                        <div class="percent">
                            {{
                                getPercent(
                                    data.quiz.log[data.quiz.log.length - 1]
                                        .score,
                                    data.quiz.log[data.quiz.log.length - 1]
                                        .total_questions
                                )
                            }}%
                        </div>
                        <div>
                            <h4 class="mt-3 text-lg">
                                {{
                                    generateText(
                                        getPercent(
                                            data.quiz.log[
                                                data.quiz.log.length - 1
                                            ].score,
                                            data.quiz.log[
                                                data.quiz.log.length - 1
                                            ].total_questions
                                        )
                                    )
                                }}
                            </h4>
                            <p>
                                You've got
                                <strong>{{
                                    data.quiz.log[data.quiz.log.length - 1]
                                        .score
                                }}</strong>
                                out of
                                <strong>{{
                                    data.quiz.log[data.quiz.log.length - 1]
                                        .total_questions
                                }}</strong>
                                questions correct!
                            </p>
                        </div>

                        <br />

                        <div class="action flex gap-4 justify-center">
                            <Button @click="retake" size="md" label="Retake" />
                            <Button
                                v-if="canNext()"
                                size="md"
                                label="Next Lesson"
                                iconRight="fa fa-angle-right"
                                @click="nextLesson"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="quiz-con">
                    <div class="header flex justify-between items-center">
                        <div>
                            <strong
                                >Question {{ data.currentIndex + 1 }} of
                                {{ data.total }}</strong
                            >
                        </div>
                        <template v-if="data.submitting">
                            <Spinner :text-new-line="false"></Spinner>
                        </template>
                        <div v-else class="timer">
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
                                    v-html="
                                        questions[data.currentIndex].question
                                    "
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
                                        v-model="
                                            data.answers[data.currentIndex]
                                        "
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
                                    :disabled="data.submitting"
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
        </div>
        <div v-else class="flex items-center">
            <div class="">
                <div class="ck" v-html="currentLesson.description"></div>
                <Button
                    :disabled="data.loading"
                    @click="startQuiz()"
                    label="Start Quiz"
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
        currentLesson: {
            type: Object,
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
            quiz: null,
            submitting: false,
            retake: false,
        });

        function onClose() {
            emit("close");
        }

        const startQuiz = async () => {
            try {
                data.value.loading = true;
                const res = await service.startQuiz(
                    props.course_id,
                    props.lesson_id
                );
                data.value.quiz = res.data.record;
                data.value.quiz.log = [];
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

        const handleSubmit = async (timeUp = false) => {
            const attempt = data.value.answers;
            const id = data.value.quiz.id;
            if (timeUp) {
                processForm();
            } else {
                const conf = confirm("You are about to submit");
                if (conf) {
                    processForm();
                }
            }

            async function processForm() {
                try {
                    data.value.submitting = true;
                    const res = await service.submitQuiz(
                        id,
                        JSON.stringify(attempt)
                    );

                    data.value.quiz.log.push(res.data.record);
                    data.value.submitting = false;
                    data.value.retake = false;
                } catch (err) {
                    ("");
                }
            }
        };

        const handleTimeUp = () => {
            handleSubmit(true);
        };

        const getProgress = () => {
            return Math.floor(
                (data.value.currentIndex / (data.value.total - 1)) * 100
            );
        };

        const getQuiz = async () => {
            const {
                data: { data: quiz },
            } = await service.getQuiz(props.lesson_id);

            data.value.quiz = quiz;
            data.value.started = true;
        };

        const generateText = (percentScore) => {
            let msg;
            let val = percentScore;
            switch (true) {
                case val < 50:
                    msg = `Please Study!`;
                    break;
                case val <= 60:
                    msg = `Not Bad!`;
                    break;
                case val <= 70:
                    msg = `You are almost there!`;
                    break;
                case val <= 99:
                    msg = `Great Score!`;
                    break;
                case val == 100:
                    msg = `Perfect!`;
                    break;
                default:
                    break;
            }

            return msg;
        };

        const getPercent = (score, total) => {
            return Math.round((score / total) * 100);
        };

        const canNext = () => {
            let result = false;
            data.value?.quiz?.log.forEach((log) => {
                const sPercent = getPercent(log.score, log.total_questions);
                if (sPercent >= Number(window.AppConfig.course_pass_percent)) {
                    result = true;
                    return;
                } else {
                    result = false;
                }
            });
            console.log(result);
            return result;
        };

        onMounted(() => {
            data.value.answers = props.questions.map((q) => {
                return {
                    question: q.id,
                    choice: null,
                };
            });

            getQuiz();
        });

        const retake = () => {
            data.value.retake = true;
            data.value.answers = [];
            data.value.currentIndex = 0;
        };

        const nextLesson = () => {
            emit("next");
        };

        return {
            onClose,
            data,
            startQuiz,
            handleNext,
            handlePrev,
            handleSubmit,
            handleTimeUp,
            getProgress,
            generateText,
            getPercent,
            retake,
            canNext,
            nextLesson,
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
.results {
    margin: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    max-width: 600px;
    .con {
        padding: 10px;

        .percent {
            height: 100px;
            width: 100px;
            display: flex;
            background: #98ca9b;
            margin: auto;
            border-radius: 100px;
            color: #fff;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            border: 10px solid #f2f6fc;
            padding: 20px;
            font-size: 24px;
            background: #79a4e1;
            color: #fff;

            &.poor {
                background: #fff9e9;
            }
            &.average {
            }
            &.good {
            }
            &.excellent {
                background: #ebfbf6;
            }
        }
    }
}
</style>
