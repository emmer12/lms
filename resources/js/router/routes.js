import { default as PageHome } from "@/views/pages/shared/Home";
import { default as PageCourses } from "@/views/pages/shared/Courses";
import { default as PageCourseDetails } from "@/views/pages/shared/CourseDetails";

import { default as PageLogin } from "@/views/pages/auth/login/Main";
import { default as PageRegister } from "@/views/pages/auth/register/Main";
import { default as PageResetPassword } from "@/views/pages/auth/reset-password/Main";
import { default as PageForgotPassword } from "@/views/pages/auth/forgot-password/Main";
import { default as PageNotFound } from "@/views/pages/shared/404/Main";

import { default as PageDashboard } from "@/views/pages/private/dashboard/Main";
import { default as PageProfile } from "@/views/pages/private/profile/Main";
import { default as PageMyCourse } from "@/views/pages/private/course/MyCourses";

import { default as PageUsers } from "@/views/pages/private/users/Index";
import { default as PageUsersCreate } from "@/views/pages/private/users/Create";
import { default as PageUsersEdit } from "@/views/pages/private/users/Edit";

import { default as PageCourse } from "@/views/pages/private/course/Index";
import { default as PageCourseCreate } from "@/views/pages/private/course/Create";
import { default as PageCourseEdit } from "@/views/pages/private/course/Edit";
import { default as PageLessonCreate } from "@/views/pages/private/course/lesson/Create";
import { default as PageLessons } from "@/views/pages/private/course/lesson/Index";
import { default as PageLessonsQuestionCreate } from "@/views/pages/private/course/lesson/question/Create";
import { default as PageLessonsQuestionList } from "@/views/pages/private/course/lesson/question/Index";

import { default as PageLearningMain } from "@/views/pages/private/course/learning/PageLearningMain";
import { default as PageLearning } from "@/views/pages/private/course/learning/PageLearning";

import abilities from "@/stub/abilities";

const routes = [
    {
        name: "home",
        path: "/",
        meta: { requiresAuth: false },
        component: PageHome,
    },
    {
        name: "courses",
        path: "/courses",
        meta: { requiresAuth: false },
        component: PageCourses,
    },
    {
        name: "course.details",
        path: "/courses/:slug",
        meta: { requiresAuth: false },
        component: PageCourseDetails,
    },
    {
        name: "my.learning",
        path: "/my/learning/:id",
        component: PageLearningMain,
        meta: { requiresAuth: true },
    },
    {
        name: "course.learning",
        path: "/courses/learning",
        component: PageLearningMain,
        children: [
            {
                name: "learning.",
                path: ":slug",
                meta: { requiresAuth: true },
                component: PageLearning,
            },
        ],
    },
    {
        name: "panel",
        path: "/panel",
        children: [
            {
                name: "dashboard",
                path: "dashboard",
                meta: { requiresAuth: true },
                component: PageDashboard,
            },
            {
                name: "profile",
                path: "profile",
                meta: { requiresAuth: true, isOwner: true },
                component: PageProfile,
            },
            {
                name: "my.courses",
                path: "my-courses",
                meta: { requiresAuth: true, isOwner: true },
                component: PageMyCourse,
            },
            {
                path: "users",
                children: [
                    {
                        name: "users.list",
                        path: "list",
                        meta: {
                            requiresAuth: true,
                            requiresAbility: abilities.LIST_USER,
                        },
                        component: PageUsers,
                    },
                    {
                        name: "users.create",
                        path: "create",
                        meta: {
                            requiresAuth: true,
                            requiresAbility: abilities.CREATE_USER,
                        },
                        component: PageUsersCreate,
                    },
                    {
                        name: "users.edit",
                        path: ":id/edit",
                        meta: {
                            requiresAuth: true,
                            requiresAbility: abilities.EDIT_USER,
                        },
                        component: PageUsersEdit,
                    },
                ],
            },
            {
                path: "course",
                children: [
                    {
                        name: "course.list",
                        path: "list",
                        meta: {
                            requiresAuth: true,
                            requiresAbility: abilities.LIST_COURSE,
                        },
                        component: PageCourse,
                    },
                    {
                        name: "course.create",
                        path: "create",
                        meta: {
                            requiresAuth: true,
                            requiresAbility: abilities.CREATE_COURSE,
                        },
                        component: PageCourseCreate,
                    },
                    {
                        name: "course.edit",
                        path: ":id/edit",
                        meta: {
                            requiresAuth: true,
                            requiresAbility: abilities.EDIT_COURSE,
                        },
                        component: PageUsersEdit,
                    },
                    {
                        name: "course.lesson.create",
                        path: ":id/lesson/create",
                        meta: {
                            requiresAuth: true,
                            requiresAbility: abilities.CREATE_LESSON,
                        },
                        component: PageLessonCreate,
                    },
                    {
                        name: "course.lesson.list",
                        path: ":id/lessons",
                        meta: {
                            requiresAuth: true,
                            requiresAbility: abilities.VIEW_LESSON,
                        },
                        component: PageLessons,
                    },
                    {
                        name: "course.lesson.question.create",
                        path: ":courseId/lesson/:id/question/create",
                        meta: {
                            requiresAuth: true,
                            requiresAbility: abilities.VIEW_LESSON,
                        },
                        component: PageLessonsQuestionCreate,
                    },
                    {
                        name: "course.lesson.question.list",
                        path: ":courseId/lesson/:id/question/list",
                        meta: {
                            requiresAuth: true,
                            requiresAbility: abilities.VIEW_LESSON,
                        },
                        component: PageLessonsQuestionList,
                    },
                ],
            },
        ],
    },
    {
        path: "/login",
        name: "login",
        meta: { requiresAuth: false },
        component: PageLogin,
    },
    {
        path: "/register",
        name: "register",
        meta: { requiresAuth: false },
        component: PageRegister,
    },
    {
        path: "/reset-password",
        name: "resetPassword",
        meta: { requiresAuth: false },
        component: PageResetPassword,
    },
    {
        path: "/forgot-password",
        name: "forgotPassword",
        meta: { requiresAuth: false },
        component: PageForgotPassword,
    },
    {
        path: "/:catchAll(.*)",
        name: "notFound",
        meta: { requiresAuth: false },
        component: PageNotFound,
    },
];

export default routes;
