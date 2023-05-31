import ModelService from "@/services/ModelService";

export default class CourseService extends ModelService {
    constructor() {
        super();
        this.url = "/course";
    }

    public getAllCourse(params = {}) {
        let path = "/course-all";
        let query = new URLSearchParams(params).toString();
        if (query) {
            path += "?" + query;
        }
        return this.get(path, {});
    }

    public getCourse(slug) {
        let path = `/course-all/${slug}`;
        return this.get(path, {});
    }

    public getMyCourse(params = {}) {
        let path = "/course-my";
        let query = new URLSearchParams(params).toString();
        if (query) {
            path += "?" + query;
        }
        return this.get(path, {});
    }

    public getCourseLessons(course_id, params = {}) {
        let path = "/course-lessons/" + course_id;
        let query = new URLSearchParams(params).toString();
        if (query) {
            path += "?" + query;
        }
        return this.get(path, {});
    }

    public updateAvatar(id, payload) {
        const formData = new FormData();
        formData.append("avatar", payload.avatar);
        formData.append("_method", "put");
        return this.post(`/users/${id}/avatar`, formData);
    }

    public handleCreateLesson(elem, form) {
        this.url = `/course/${form.course_id}/lessons`;
        return this.handleCreate(elem, form);
    }

    public getLessons(params, id) {
        let path = `/course/${id}/lessons`;
        let query = new URLSearchParams(params).toString();
        if (query) {
            path += "?" + query;
        }
        return this.get(path, {});
    }

    public getLessonQuestions(params, id) {
        let path = `/course/${id}/questions`;
        let query = new URLSearchParams(params).toString();
        if (query) {
            path += "?" + query;
        }
        return this.get(path, {});
    }

    public getLessonMaterials(params, id) {
        let path = `/course/${id}/materials`;
        let query = new URLSearchParams(params).toString();
        if (query) {
            path += "?" + query;
        }
        return this.get(path, {});
    }

    public handleCreateQuestion(elem, form) {
        this.url = `/course/${form.lesson_id}/questions`;
        return this.handleCreate(elem, form);
    }

    public handleCreateMaterial(elem, form) {
        this.url = `/course/${form.lesson_id}/materials`;
        return this.handleCreate(elem, form);
    }

    public handleEnroll(form) {
        this.url = `/course/enroll`;
        return this.handleCreate("elem", form);
    }

    public startQuiz(course_id, lesson_id) {
        return this.post(`/course/quiz/start`, { course_id, lesson_id });
    }

    public submitQuiz(quiz_id, answers) {
        return this.post(`/course/quiz/submit`, { quiz_id, answers });
    }

    public getQuiz(lesson_id) {
        let path = "/course/quiz/" + lesson_id;
        return this.get(path);
    }

    public markCompleted(lesson_id) {
        let path = "/course/lesson/completed/" + lesson_id;
        return this.patch(path, {});
    }

    public getHomePageData() {
        let path = "/home-page-data";
        return this.get(path);
    }

    public getUserDashboardData() {
        let path = "/dash-page-data";
        return this.get(path);
    }
}
