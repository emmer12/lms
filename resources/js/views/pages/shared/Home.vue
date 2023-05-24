<template>
    <Guest>
        <div class="banner">
            <div class="container-x">
                <div class="flex">
                    <div class="content flex-1 w-fill/2">
                        <h4 class="mb-4">Welcome KingsWord Learning Portal</h4>
                        <h2 class="mb-8">
                            Start Better Learning Future From Here
                        </h2>

                        <Button class="mb-16" label="Get Started Today" />
                        <div class="flex item-center mb-16"></div>

                        <p class="note">
                            Lorem ipsum dolor sit amet, consectetur adipisicing
                            elit. Ad voluptate cupiditate inventore.
                        </p>
                    </div>
                    <div class="artworks flex-1">
                        <div class="flex">
                            <div class="flex flex-col">
                                <CourseCard1 />
                                <div class="card work">
                                    <img
                                        src="/assets/images/a1.png"
                                        alt="Images"
                                    />
                                    <div class="info">
                                        <h4>Design Workshop</h4>
                                        <p>Today at 6:00am</p>
                                    </div>
                                    <Button
                                        label="Join Now"
                                        size="sm"
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

        <!-- Course Sections -->

        <div class="course-section">
            <div class="container-x">
                <Header
                    title="Featured On This Month"
                    subtitle="Popular Courses"
                />
                <div class="courses-grid grid">
                    <course-card-1 />
                    <course-card-1 />
                    <course-card-1 />
                    <course-card-1 />
                </div>
            </div>
        </div>

        <!-- Meet Out Pastors -->

        <div class="out-pastor-section">
            <div class="container-x">
                <div class="flex">
                    <div class="img flex-1">
                        <img src="/assets/images/img1.jpg" alt="Pastor" />
                    </div>
                    <div class="details flex-1">
                        <h2>
                            Our parish <br />
                            <span>Couch</span>
                        </h2>
                        <p>
                            Pastor Gbolahan Railey are the Lead Pastors of RCCG
                            Church in Uk. They’ve been in pastoral ministry for
                            over 20 years.
                        </p>

                        <br />

                        <!-- <Button label="LEARN MORE" class="block" /> -->
                    </div>
                </div>
            </div>
        </div>
    </Guest>
</template>

<script>
import Guest from "@/views/layouts/Guest";
import AppDownload from "@/views/components/AppDownload";
export default {
    components: {
        Guest,
        AppDownload,
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

.out-pastor-section {
    background: #fff;
    padding: 100px 0px;
    .details {
        padding: 20px 50px;
    }

    h2 {
        font-size: 4.2em;
        font-weight: 800;
        text-transform: uppercase;
        line-height: 64px;
    }

    p {
        /* font-size: 16px; */
        font-weight: 500;
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
    background: #fff;
    padding: 50px 0px;

    .courses-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        padding: 30px 0px;
    }
}
</style>
