<template>
    <Guest>
        <div class="banner">
            <div class="container-x">
                <div class="flex flex-col sm:flex-row">
                    <div class="content flex-1 w-full sm:w-fill/2">
                        <h4 class="mb-4 font-reey">Welcome to</h4>
                        <h2 class="mb-8">KingsWord Learning institute</h2>

                        <Button
                            class="mb-4 sm:mb-16"
                            label="Get Started Today"
                        />
                        <div class="flex item-center mb-4 sm:mb-16"></div>

                        <p class="note">
                            Grow your spirit and become part of the growing
                            supernatural armies.
                        </p>
                    </div>
                    <div class="artworks flex-1">
                        <div class="flex">
                            <div class="flex flex-col">
                                <div v-if="results.featured">
                                    <CourseCard1 :course="results.featured" />
                                </div>
                                <div class="card work">
                                    <img
                                        src="/assets/images/a1.png"
                                        alt="Images"
                                    />
                                    <div class="info">
                                        <h4>Student Signup</h4>
                                        <p>Become a member</p>
                                    </div>
                                    <Button
                                        label="Join Now"
                                        size="sm"
                                        to="/register"
                                        iconRight="fa fa-arrow-right"
                                    />
                                </div>
                            </div>
                            <div>
                                <img
                                    src="/assets/images/video-image-2.png"
                                    alt="Video Image"
                                    class="v-img"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meet Out Pastors -->

        <div class="our-pastor-section">
            <div class="container-x">
                <div class="flex flex-col sm:flex-row">
                    <div class="img flex-1">
                        <img src="/assets/images/img2.webp" alt="Pastor" />
                    </div>
                    <div class="details flex-1">
                        <h4>KMI LEARNING PORTAL</h4>
                        <h2>Welcome to KingsWord Learning Institute</h2>
                        <p>
                            Here we can have short information about the portal
                            and the mission on the website. Here we can have
                            short information about the portal and the mission
                            on the website. Here we can have short information
                            about the portal and the mission on the website.
                        </p>

                        <div class="list">
                            <div class="flex my-3 items-center">
                                <confirmed />
                                <p>Get unlimited access to KTI resources</p>
                            </div>
                            <div class="flex my-3 items-center">
                                <confirmed />
                                <p>
                                    Explore a variety of faith building
                                    materials
                                </p>
                            </div>
                            <div class="flex my-3 items-center">
                                <confirmed />
                                <p>
                                    Find the best qualitfied teacher of the
                                    gospel
                                </p>
                            </div>
                            <div class="flex my-3 items-center">
                                <confirmed />
                                <p>
                                    Grow in your faith, and mature in the spirit
                                </p>
                            </div>
                        </div>

                        <br />

                        <!-- <Button label="LEARN MORE" class="block" /> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Sections -->

        <div class="course-section">
            <div class="container-x">
                <Header
                    title="Featured On This Month"
                    subtitle="Featured Courses"
                />

                <div
                    v-if="results.courses.length && !results.loading"
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4"
                >
                    <course-card
                        v-for="course in results.courses"
                        :key="course.id"
                        :course="course"
                    />
                </div>

                <div v-else>
                    <template v-if="results.loading">
                        <Spinner :text-new-line="true"></Spinner>
                    </template>
                    <template v-else>
                        {{ trans("global.phrases.no_records") }}
                    </template>
                </div>
            </div>
        </div>

        <div class="mission-section">
            <div class="container-x">
                <div class="flex flex-col sm:flex-row">
                    <div class="left w-full sm:w-1/3">
                        <h4>KTI Mission</h4>
                        <h2>Our Mission is to make you grow spiritually</h2>
                        <p>
                            Grow your spirit and become part of the growing
                            supernatural armies.
                        </p>
                    </div>

                    <div class="right flex">
                        <div class="box">
                            <Teacher />
                            <h4>20</h4>
                            <p>Pro Teachers</p>
                        </div>
                        <div class="box">
                            <OnlineCourse />
                            <h4>50</h4>
                            <p>Courses</p>
                        </div>
                        <div class="box">
                            <Student />
                            <h4>6,000</h4>
                            <p>Enrolled Students</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Guest>
</template>

<script>
import Guest from "@/views/layouts/Guest";
import AppDownload from "@/views/components/AppDownload";
import Student from "@/views/components/icons/Student.vue";
import Teacher from "@/views/components/icons/Teacher.vue";
import OnlineCourse from "@/views/components/icons/OnlineCourse.vue";
import Confirmed from "@/views/components/icons/Confirmed.vue";
import { watch, onMounted, reactive, computed } from "vue";
import { trans } from "@/helpers/i18n";
import CourseService from "@/services/CourseService";

export default {
    components: {
        Guest,
        AppDownload,
        Student,
        Teacher,
        OnlineCourse,
        Confirmed,
    },

    setup() {
        const service = new CourseService();

        const results = reactive({
            courses: [],
            featured: null,
            loading: false,
        });

        function getPageData() {
            service
                .getHomePageData()
                .then((response) => {
                    results.courses = response.data.courses;
                    results.featured = response.data.featured;
                    results.loading = false;
                })
                .catch((error) => {
                    results.loading = false;
                });
        }

        onMounted(() => {
            getPageData();
        });

        return {
            results,
            trans,
        };
    },
};
</script>

<style lang="scss" scoped>
.banner {
    background: linear-gradient(50deg, #140741, #fcad03);
    /* background-image: url(/assets/images/banner1.png); */
    /* height: 663px; */
    position: relative;

    .content {
        padding-top: 128px;
        width: 50%;

        h4 {
            font-size: 16px;
            text-transform: uppercase;
            color: #fff;
            font-weight: 700;
        }

        h2 {
            font-size: 64px;
            /* text-transform: uppercase; */
            color: #fff;
            font-weight: 700;
            letter-spacing: -0.01em;
            line-height: 82px;
        }

        p.note {
            font-size: 16px;
            color: #fff;
            position: relative;
            margin-left: 42px;

            &:after {
                content: "";
                position: absolute;
                width: 31px;
                height: 2px;
                background: #6541e6;
                left: -39px;
                top: 12px;
            }
        }
    }

    .artworks {
        padding: 50px 0px;
    }
}

.v-img {
    position: absolute;
    right: 0px;
}

.our-pastor-section {
    background: #fff;
    padding: 100px 0px 0px 0px;

    .img {
        height: 400px;
        width: 100%;

        img {
            height: 100%;
            object-fit: cover;
        }
    }
    .details {
        padding: 20px 50px;
    }

    h4 {
        font-size: 20px;
        color: #6541e6;
        font-weight: 700;
    }

    h2 {
        font-size: 50px;
        font-weight: 800;
        line-height: 50px;
        margin: 10px 0px;
    }

    p {
        /* font-size: 16px; */
        font-weight: 500;
    }

    .list {
        svg {
            height: 20px;
            width: 20px;
            fill: #fcad03;
            margin-right: 15px;
        }
    }
}

.card.work {
    box-shadow: 0px 10px 25px 0px rgba(0, 0, 0, 0.05);
    transition: background 0.3s, border 0.3s, border-radius 0.3s,
        box-shadow 0.3s;
    background: #fff;
    margin-top: 10px;
    padding: 20px;
    width: fit-content;
    align-self: end;
    border-radius: 5px;

    .info {
        margin: 15px 0px;
        h4 {
            font-size: 18px;
            font-weight: 600;
        }
        p {
            font-size: 14px;
            font-weight: 600;
            line-height: 22px;
        }
    }
}

.course-section {
    background: #f2f6fc;
    padding: 50px 0px;

    .courses-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        padding: 30px 0px;
    }
}

.mission-section {
    background-image: linear-gradient(
            hsl(216deg 87% 27% / 70%),
            rgb(22 23 34 / 100%)
        ),
        url(/assets/images/BEN_4677.webp);
    background-position: center center;
    background-size: cover;
    background-attachment: fixed;
    padding: 100px 0px;

    .left {
        color: #fff;

        h4 {
            text-transform: uppercase;
            font-size: 20px;
            color: #fcad03;
        }

        h2 {
            font-weight: 700;
            font-size: 50px;
            color: #fff;
            margin: 0px;
            line-height: 50px;
        }

        p {
            margin-top: 20px;
            color: rgba(255, 255, 255, 0.8);
        }
    }

    .right {
        flex: 1;
        .box {
            margin: 10px;
            background: #140741;
            padding: 20px;
            border-radius: 20px;
            text-align: center;
            height: 200px;
            width: 200px;

            h4 {
                font-weight: 900;
                color: #fff;
                font-size: 26px;
                margin: 10px 0px;
            }

            p {
                color: rgba(255, 255, 255, 0.8);
            }

            svg {
                height: 50px;
                width: 50px;
                margin: auto;
            }
        }
    }
}

@media (max-width: 640px) {
    .banner {
        background: linear-gradient(50deg, #140741, #fcad03);
        overflow: hidden;
        .content {
            padding-top: 80px;
            width: 100%;
            h2 {
                font-size: 32px;
                line-height: 42px;
            }

            p.note {
                margin-left: 12px;
                &:after {
                    background: #fff;
                }
            }
        }

        .artworks {
            padding: 50px 0px;
        }

        .v-img {
            right: -50%;
            top: 43%;
        }
    }

    .course-section {
        padding: 30px 0px;

        .courses-grid {
            grid-template-columns: repeat(1, 1fr);
        }
    }

    .our-pastor-section {
        padding: 50px 0px;
        .details {
            padding: 20px 10px;
        }

        h2 {
            font-size: 2.2em;
            line-height: 32px;
        }
    }

    .mission-section {
        padding: 50px 0px;

        .left {
            h4 {
                font-size: 18px;
            }

            h2 {
                font-size: 32px;
                line-height: 32px;
            }
        }

        .right {
            margin-top: 30px;
            flex: 1;
            .box {
                padding: 10px;
                border-radius: 10px;
                height: 125px;
                width: 125px;

                h4 {
                    font-size: 18px;
                }

                p {
                    font-size: 12px;
                    margin-top: 10px;
                }

                svg {
                    height: 25px;
                    width: 25px;
                }
            }
        }
    }
}
</style>
