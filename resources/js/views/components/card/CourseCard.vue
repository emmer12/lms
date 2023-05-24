<template>
    <div class="contain">
        <div class="wrapper">
            <div class="display">
                <router-link
                    :to="{
                        name: 'course.details',
                        params: { slug: course.slug },
                    }"
                >
                    <img
                        src="/assets/images/course2.jpg"
                        alt="Display Thumbnail"
                    />
                </router-link>
            </div>
            <div class="content">
                <div class="price">
                    <div v-if="course.price > 0">${{ course.price }}</div>
                    <div v-else>
                        <h4>Free</h4>
                    </div>
                </div>
                <div class="info">
                    <h4>{{ course.title }}</h4>
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
                        <span class="text-md">13 Lesson</span>
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
                    <div class="flex items-center gap-2">
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
                            class="feather feather-users"
                        >
                            <path
                                d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"
                            ></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span class="text-md">Students</span>
                    </div>
                </div>

                <hr />

                <div class="flex mt-5 mb-2">
                    <Button label="Enroll Now" iconRight="fa fa-arrow-right" />
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

<style lang="scss">
.contain {
    box-shadow: 0 10px 30px rgb(0 0 0 / 6%);
    background: #f2f6fc;
    border-radius: 5px;
    min-width: 100%;
    max-width: 320px;
    /* width: 260px; */
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

    .content {
        span {
            color: #6f6b80;
            font-weight: 500;
        }

        .s2 {
            svg {
                height: 18px;
                width: 18px;
            }
        }

        .price {
            margin-top: 15px;
            font-size: 16px;
            color: #5985d8;
            font-weight: 800;
        }
    }

    .info {
        h4 {
            font-size: 24px;
            font-weight: 700;
        }

        p {
            font-weight: 500;
            font-size: 14px;
            line-height: 22px;
            margin-bottom: 5px;
            color: #6f6b80;
            margin: 10px 0px;
        }
    }
}
</style>
