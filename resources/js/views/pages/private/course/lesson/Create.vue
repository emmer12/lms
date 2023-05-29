<template>
    <Page
        :title="page.title"
        :breadcrumbs="page.breadcrumbs"
        :actions="page.actions"
        @action="onAction"
    >
        <Panel>
            <Form id="create-user" @submit.prevent="onSubmit">
                <TextInput
                    class="mb-4"
                    type="text"
                    :required="true"
                    name="title"
                    v-model="form.title"
                    :label="trans('Title')"
                />
                <div class="mb-3">
                    <label for="description" class="text-sm text-gray-500">
                        Description</label
                    >
                    <ckeditor
                        id="description"
                        :editor="editor"
                        v-model="form.description"
                        :config="editorConfig"
                    ></ckeditor>
                </div>
                <TextInput
                    class="mb-4"
                    type="number"
                    name="sortOrder"
                    v-model="form.sortOrder"
                    :label="trans('Sort Order')"
                />

                <TextInput
                    class="mb-4"
                    type="text"
                    name="duration"
                    v-model="form.duration"
                    :label="trans('Duration')"
                />

                <div class="mb-4">
                    <label for="article-body" class="text-sm text-gray-500">
                        Content Type</label
                    >
                    <multiselect
                        name="content_type"
                        track-by="label"
                        v-model="form.content_type"
                        label="label"
                        :options="[
                            {
                                value: 'video',
                                label: 'Video',
                            },
                            {
                                value: 'audio',
                                label: 'Audio',
                            },
                            {
                                value: 'youtube',
                                label: 'Youtube',
                            },
                            {
                                value: 'article',
                                label: 'Article',
                            },
                            {
                                value: 'quiz',
                                label: 'Quiz',
                            },
                        ]"
                    />
                </div>

                <div v-if="form.content_type.value == 'quiz'">
                    <div class="mb-4">
                        <label for="quiz_type" class="text-sm text-gray-500">
                            Quiz Type</label
                        >
                        <multiselect
                            name="quiz_type"
                            track-by="label"
                            v-model="form.quiz_type"
                            label="label"
                            :options="[
                                {
                                    value: 'test',
                                    label: 'Test',
                                },
                                {
                                    value: 'exam',
                                    label: 'Exam',
                                },
                            ]"
                        />
                    </div>
                    <TextInput
                        class="mb-4"
                        type="number"
                        name="quiz_duration"
                        v-model="form.quiz_duration"
                        :label="trans('Quiz duration')"
                        placeholder="Enter duration in minutes"
                    />
                    <span></span>
                </div>

                <div class="mb-4" v-if="form.content_type.value == 'article'">
                    <label for="article-body" class="text-sm text-gray-500">
                        Article Body</label
                    >
                    <ckeditor
                        id="article-body"
                        :editor="editor"
                        v-model="form.article_body"
                        :config="editorConfig"
                    ></ckeditor>
                </div>
                <FileInput
                    class="mb-4"
                    name="preview"
                    v-model="form.preview"
                    accept="image/*"
                    :label="trans('Preview')"
                    @click="form.preview = ''"
                ></FileInput>
            </Form>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, reactive } from "vue";
import { trans } from "@/helpers/i18n";
import { useAuthStore } from "@/stores/auth";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Dropdown from "@/views/components/input/Dropdown";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import CourseService from "@/services/CourseService";
import { clearObject, reduceProperties } from "@/helpers/data";
import { toUrl } from "@/helpers/routing";
import Form from "@/views/components/Form";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { useRouter, useRoute } from "vue-router";
import Multiselect from "vue-multiselect";

export default defineComponent({
    components: {
        Form,
        FileInput,
        Panel,
        Alert,
        Dropdown,
        TextInput,
        Button,
        Page,
        Multiselect,
    },
    setup() {
        const { user } = useAuthStore();
        const router = useRouter();
        const route = useRoute();
        const form = reactive({
            title: "",
            duration: "",
            sortOrder: "",
            content_type: "",
        });

        const editorConfig = reactive({});
        const editor = reactive(ClassicEditor);

        const page = reactive({
            id: "create_courses_lesson",
            title: trans("New Lesson"),
            filters: false,
            breadcrumbs: [
                {
                    name: trans("Course"),
                    to: toUrl("/course/list"),
                },
                {
                    name: trans("New Lesson"),
                    active: true,
                },
            ],
            actions: [
                {
                    id: "back",
                    name: trans("Back"),
                    icon: "fa fa-angle-left",
                    to: toUrl("/course/list"),
                    theme: "outline",
                },
                {
                    id: "lessons",
                    name: trans("Lessons"),
                    to: toUrl(`/course/${route.params.id}/lessons`),
                    type: "button",
                    theme: "outline",
                },
                {
                    id: "submit",
                    name: trans("global.buttons.save"),
                    icon: "fa fa-save",
                    type: "submit",
                },
            ],
        });

        const service = new CourseService();

        function onAction(data) {
            switch (data.action.id) {
                case "submit":
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            form.course_id = route.params.id;
            form.content_type = form.content_type.value;
            form.quiz_type = form.quiz_type ? form.quiz_type.value : "";
            service
                .handleCreateLesson("create_lesson", reduceProperties(form))
                .then(() => {
                    router.push({
                        name: "course.lesson.list",
                        params: { id: route.params.id },
                    });
                    // clearObject(form);
                });

            return false;
        }

        return {
            trans,
            user,
            form,
            page,
            onSubmit,
            onAction,
            editorConfig,
            editor,
        };
    },
});
</script>

<style scoped>
#article-body {
    min-height: 400px;
}
</style>
