<template>
    <Guest>
        <div class="course-section">
            <div class="banner">
                <div class="container-x">
                    <div>
                        <h2>About Us</h2>
                    </div>
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol
                            class="inline-flex items-center space-x-1 md:space-x-3"
                        >
                            <li class="inline-flex items-center">
                                <router-link
                                    to="/"
                                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                                >
                                    <i class="fa fa-home mr-3"></i>
                                    Home
                                </router-link>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fa fa-angle-right"></i>
                                    <span
                                        class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                                        v-text="'About'"
                                    ></span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="py-10">
                <div class="container-x">
                    <div class="about w-[600px] max-w-full m-auto">
                        <img
                            src="assets/images/img1.jpg"
                            alt=" Pastor May & Dr. Kay"
                        />

                        <h4>
                            Welcome to KingsWord Learning Portal, your premier
                            online spiritual development centre!
                        </h4>

                        <p>
                            This learning portal is committed to providing
                            high-quality biblical education and spiritual
                            development to individuals seeking to deepen their
                            understanding of the Word of God. Our learning
                            portal is designed to equip believers with the
                            knowledge, wisdom, and practical skills needed to
                            grow in their faith and serve God effectively.
                        </p>

                        <div>
                            <h4>Our Mission:</h4>
                            <p>
                                Our mission is to empower individuals with a
                                solid foundation in Christian theology, biblical
                                principles, and practical ministry skills. We
                                strive to cultivate disciples who are rooted in
                                God's Word, empowered by the Holy Spirit, and
                                equipped to make a positive impact in their
                                communities and the world.
                            </p>
                        </div>

                        <div>
                            <h4>Our Courses:</h4>
                            <p>
                                We offer a comprehensive range of courses and
                                programs that cover various aspects of biblical
                                studies and Christian ministry. Our curriculum
                                is carefully crafted to provide a well-rounded
                                education that combines academic rigor with
                                spiritual formation. Some of the key areas we
                                focus on include:
                            </p>
                        </div>

                        <div>
                            <h4>Biblical Studies:</h4>
                            <p>
                                Dive deep into the Scriptures and gain a
                                thorough understanding of the Old and New
                                Testaments. Our courses cover topics such as
                                basic believers’ study, theology, Grace, Faith
                                and the historical context of the Bible.
                            </p>
                        </div>

                        <div>
                            <h4>Ministry and Leadership:</h4>
                            <p>
                                Develop practical ministry skills and leadership
                                abilities. Learn about pastoral care, preaching,
                                teaching, evangelism, discipleship, worship, and
                                other aspects of Christian ministry.
                            </p>
                        </div>

                        <div>
                            <h4>Spiritual Formation:</h4>
                            <p>
                                Cultivate a vibrant and intimate relationship
                                with God through courses focused on prayer,
                                spiritual disciplines, spiritual warfare, and
                                Christian living. Deepen your faith and grow in
                                your walk with the Lord.
                            </p>
                        </div>

                        <div>
                            <h4>Missions and Outreach:</h4>
                            <p>
                                Equip yourself for global missions and local
                                outreach. Discover strategies for sharing the
                                Gospel, engaging with diverse cultures, and
                                making a difference in the world through acts of
                                compassion and justice.
                            </p>
                        </div>

                        <div>
                            <h4>Learning Experience:</h4>
                            <p>
                                We strive to provide a transformative learning
                                experience that goes beyond intellectual
                                knowledge. Our courses incorporate prayer,
                                worship, and a focus on personal spiritual
                                growth. You will have access to engaging course
                                materials, video lectures, interactive
                                discussions, and practical assignments to apply
                                what you learn to real-life ministry contexts.
                            </p>
                        </div>

                        <div>
                            <h4>Expert Instructors:</h4>
                            <p>
                                Our instructors are seasoned ministers,
                                theologians, and scholars who have a passion for
                                teaching and mentoring. They bring their
                                extensive knowledge and practical experience to
                                the virtual classroom, guiding students through
                                their learning journey with wisdom, insight, and
                                a heart for discipleship.
                            </p>
                        </div>

                        <div>
                            <h4>Community and Support::</h4>
                            <p>
                                We believe in the power of community and the
                                importance of mutual support. You will have
                                opportunities to connect with fellow students,
                                engage in discussions, and participate in online
                                forums. Our dedicated support team is also
                                available to assist you throughout your learning
                                experience.
                            </p>
                            <p>
                                Join us at KingsWord Learning Portal and embark
                                on a transformative journey of deepening your
                                understanding of God's Word, growing in your
                                faith, and fulfilling your calling as a follower
                                of Christ. Together, let us pursue excellence in
                                biblical education and be equipped to impact the
                                world for God's kingdom.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Meet Out Pastors -->
    </Guest>
</template>

<script>
import { watch, onMounted, reactive, computed } from "vue";
import CourseService from "@/services/CourseService";
import Guest from "@/views/layouts/Guest";
import AppDownload from "@/views/components/AppDownload";
import Pager from "@/views/components/Pager";
import { getResponseError, prepareQuery } from "@/helpers/api";
import { trans } from "@/helpers/i18n";
import Spinner from "@/views/components/icons/Spinner";

export default {
    components: {
        Guest,
        AppDownload,
        Pager,
        Spinner,
    },
    setup() {
        const service = new CourseService();

        const results = reactive({
            records: [],
            loading: false,
            pagination: {
                meta: null,
                links: null,
            },
        });
        const mainQuery = reactive({
            page: 1,
            search: "",
            sort: "",
            filters: {},
        });

        function fetchPage(params) {
            results.records = [];
            results.loading = true;
            let query = prepareQuery(params);
            service
                .getAllCourse(query)
                .then((response) => {
                    results.records = response.data.data;
                    results.pagination.meta = response.data.meta;
                    results.pagination.links = response.data.links;
                    results.loading = false;
                })
                .catch((error) => {
                    // alertStore.error(getResponseError(error));
                    results.loading = false;
                });
        }

        watch(mainQuery, (newTableState) => {
            fetchPage(mainQuery);
        });

        onMounted(() => {
            fetchPage(mainQuery);
        });

        function getPaginationMeta(key) {
            let value = null;
            if (results.pagination) {
                if (
                    results.pagination.hasOwnProperty("meta") &&
                    results.pagination.meta
                ) {
                    if (results.pagination.meta.hasOwnProperty(key)) {
                        value = results.pagination.meta[key];
                    }
                }
            }
            return value;
        }

        function onPagerInput(page) {
            mainQuery.page = page;
        }

        const currentPage = computed(() => {
            return getPaginationMeta("current_page");
        });
        const lastPage = computed(() => {
            return getPaginationMeta("last_page");
        });

        return {
            results,
            trans,
            currentPage,
            lastPage,
            onPagerInput,
        };
    },
};
</script>

<style lang="scss" scoped>
.banner {
    padding-top: 60px;
    padding-bottom: 60px;
    background: #d7e5ff;
    position: relative;
    text-align: left;

    h2 {
        margin: 0 0 5px 0;
        font-size: 40px;
        font-weight: 700;
        line-height: 1.4;
        color: var(--color-heading);
    }
}

@media (max-width: 640px) {
    .banner {
        h2 {
            font-size: 24px;
        }
    }
}

.about {
    h4 {
        font-size: 20px;
        font-weight: 700;
        margin: 10px 0px;
    }

    p {
        margin: 15px 0px;
    }
}
</style>
