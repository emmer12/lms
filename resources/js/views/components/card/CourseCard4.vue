<template>
    <div class="contains cursor-pointer">
        <div class="wrapper flex items-center">
            <div
                x-data="scrollProgress"
                class="inline-flex items-center justify-center overflow-hidden rounded-full bottom-5 left-5"
            >
                <!-- Building a Progress Ring: https://css-tricks.com/building-progress-ring-quickly/ -->
                <svg class="w-[100px] h-[100px]">
                    <circle
                        class="text-gray-300"
                        stroke-width="5"
                        stroke="currentColor"
                        fill="transparent"
                        r="20"
                        cx="50"
                        cy="50"
                    />
                    <circle
                        class="text-blue-600"
                        stroke-width="5"
                        :stroke-dasharray="circumference"
                        :stroke-dashoffset="
                            circumference -
                            (course.pivot.progress / 100) * circumference
                        "
                        stroke-linecap="round"
                        stroke="currentColor"
                        fill="transparent"
                        r="20"
                        cx="50"
                        cy="50"
                    />
                </svg>
                <span class="absolute text-sm text-blue-700">
                    {{ course.pivot.progress }}%</span
                >
            </div>

            <div class="content">
                <div class="info">
                    <h4 class="font-bold text-xl">{{ course.title }}</h4>
                </div>

                <div class="flex my-4 s2">
                    <div class="flex items-center gap-2 mr-4">
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
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span class="text-md"
                            >{{ course.lessons_count }} Lesson</span
                        >
                    </div>
                    <div class="flex items-center gap-2 mr-4">
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
                            class="feather feather-clock"
                        >
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span class="text-md">{{ course.duration }}</span>
                    </div>
                </div>
                <div class="self-end text-end">
                    <router-link
                        :to="{
                            name: 'my.learning',
                            params: { id: course.id },
                        }"
                        class="text-theme-800 font-bold"
                    >
                        Continue
                    </router-link>
                </div>
            </div>

            <!-- <div class="content">
                <div class="info my-3">
                    <h4 class="font-bold">{{ course.title }}</h4>
                </div>
                <div
                    class="w-full bg-gray-200 rounded-full h-0.5 mb-4 dark:bg-gray-700"
                >
                    <div
                        class="bg-blue-600 h-0.5 rounded-full"
                        :style="`width: ${course?.course_log?.progress}%`"
                    ></div>
                    <span
                        v-if="course?.course_log?.progress > 0"
                        class="text-xs"
                        >{{ course?.course_log?.progress }}%</span
                    >
                    <span v-else class="text-xs">START COURSE</span>
                </div>
            </div> -->
        </div>
    </div>
</template>

<script>
export default {
    props: ["course"],

    setup() {
        const circumference = 20 * 2 * Math.PI;

        return {
            circumference,
        };
    },
};
</script>

<style lang="scss" scoped>
.contains {
    padding: 15px;
    margin: 10px 0px;
    transition: 0.3s;
    width: 100%;

    &:hover {
        background: #fff;

        img {
            transform: scale(1.1);
        }
    }

    .display {
        img {
            transition: 0.3s;
        }
        overflow: hidden;

        &:hover {
            img {
                transform: scale(1.1);
            }
        }
    }
}
</style>
