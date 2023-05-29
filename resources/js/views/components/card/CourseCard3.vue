<template>
    <div class="contains cursor-pointer">
        <div class="wrapper">
            <div class="display">
                <router-link
                    :to="{
                        name: 'my.learning',
                        params: { id: course.id },
                    }"
                >
                    <img
                        v-if="course.preview_url"
                        :src="course.preview_url"
                        alt="Display Thumbnail"
                    />
                    <img
                        v-else
                        src="/assets/images/no-preview.jpg"
                        alt="Display Thumbnail"
                    />
                </router-link>
            </div>
            <div class="content">
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
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["course"],
};
</script>

<style lang="scss" scoped>
.contains {
    box-shadow: 0 10px 30px rgb(0 0 0 / 6%);
    background: #f2f6fc;
    border-radius: 5px;
    max-width: 320px;
    width: 260px;
    padding: 15px;
    margin: 10px 0px;
    transition: 0.3s;

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
