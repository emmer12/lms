<template>
    <Page
        :title="page.title"
        :breadcrumbs="page.breadcrumbs"
        :actions="page.actions"
        @action="onAction"
    >
        <Panel>
            <Form id="create-question" @submit.prevent="onSubmit">
                <TextInput
                    class="mb-4"
                    type="text"
                    :required="true"
                    name="title"
                    v-model="form.title"
                    :label="trans('Title')"
                />
                <div class="mb-4">
                    <label for="content_type" class="text-sm text-gray-500">
                        Content Type</label
                    >
                    <multiselect
                        name="content_type"
                        v-model="form.content_type"
                        :options="['video', 'doc', 'audio']"
                    />
                </div>

                <div
                    class="mb-4"
                    v-if="
                        form.content_type == 'video' ||
                        form.content_type == 'audio'
                    "
                >
                    <label for="source" class="text-sm text-gray-500">
                        Source</label
                    >
                    <multiselect
                        name="source"
                        v-model="form.source"
                        :options="['embed', 'upload', 'video_link']"
                    />
                </div>

                <div class="mb-4" v-if="form.source == 'video_link'">
                    <TextInput
                        class="mb-4"
                        type="textarea"
                        :required="true"
                        name="video_link"
                        v-model="form.video_link"
                        :label="trans('Video Url')"
                    />
                </div>
                <div class="mb-4" v-else-if="form.source == 'embed'">
                    <TextInput
                        class="mb-4"
                        type="textarea"
                        :required="true"
                        name="code"
                        v-model="form.embed_code"
                        :label="trans('Embed Code')"
                    />
                </div>
                <div v-else>
                    <FileInput
                        class="mb-4"
                        name="file"
                        v-model="form.file"
                        :label="trans('Upload File')"
                        @click="form.file = ''"
                    ></FileInput>
                </div>
            </Form>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, reactive, ref } from "vue";
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
import Modal from "@/views/components/Modal";

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
        Modal,
    },
    setup() {
        const { user } = useAuthStore();
        const router = useRouter();
        const route = useRoute();
        const form = reactive({
            content_type: "",
            source: "",
        });

        const isAvatarModalShowing = ref(false);

        const editorConfig = reactive({});
        const editor = reactive(ClassicEditor);

        const page = reactive({
            id: "create_materials",
            title: trans("New Material"),
            filters: false,
            breadcrumbs: [
                {
                    name: trans("Courses"),
                    to: toUrl("/course/list"),
                },
                {
                    name: "Lessons",
                    to: toUrl(`/course/${route.params.courseId}/lessons`),
                },
                {
                    name: trans("Create"),
                    active: true,
                },
            ],
            actions: [
                {
                    id: "back",
                    name: trans("Back"),
                    icon: "fa fa-angle-left",
                    to: toUrl(
                        `course/${route.params.courseId}/lesson/${route.params.id}/question/list`
                    ),
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
            form.lesson_id = route.params.id;
            service
                .handleCreateMaterial("create_material", reduceProperties(form))
                .then(() => {
                    router.push({
                        name: "course.lesson.material.list",
                        params: {
                            id: route.params.id,
                            courseId: route.params.courseId,
                        },
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
            isAvatarModalShowing,
        };
    },
});
</script>

<style lang="scss" scoped>
.fa {
    font-size: 20px;
}
</style>
