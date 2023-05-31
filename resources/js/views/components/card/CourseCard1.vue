<template>
    <div class="contain cursor-pointer">
        <router-link
            :to="{
                name: 'course.details',
                params: { slug: course.slug },
            }"
        >
            <div class="wrapper">
                <div class="display">
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
                </div>
                <div class="content">
                    <div class="flex my-3">
                        <div class="flex items-center gap-2 mr-4">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
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
                            <span class="text-sm"
                                >{{ course.lessons_count }} Lesson</span
                            >
                        </div>
                        <div class="flex items-center gap-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
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

                    <div class="info">
                        <h4>{{ course.title }}</h4>
                        <p>
                            Welcome to Grace Academy 2023! I am thrilled to have
                            you here and I'm excited to explore this important
                            subject with you.
                        </p>
                    </div>
                </div>
            </div>
        </router-link>
    </div>
</template>

<script>
export default {
    props: ["course"],
};
</script>

<style lang="scss">
.contain {
    box-shadow: 0 10px 30px rgb(0 0 0 / 6%);
    background: #fff;
    border-radius: 5px;
    width: 260px;
    padding: 15px;
    margin: 10px 0px;

    .content {
        span {
            color: #6f6b80;
            font-weight: 500;
        }
    }

    .info {
        h4 {
            font-size: 18px;
            font-weight: 600;
        }

        p {
            font-weight: 500;
            font-size: 14px;
            line-height: 22px;
            margin-bottom: 5px;
            color: #6f6b80;
            margin: 10px 0px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    }
}
</style>
