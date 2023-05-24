<template>
    <Page
        :title="page.title"
        :breadcrumbs="page.breadcrumbs"
        :actions="page.actions"
        @action="onAction"
    >
        <Panel>
            <Form id="create-user" @submit.prevent="onSubmit">
                <div class="mb-4">
                    <label for="article-body" class="text-sm text-gray-500">
                        Question Type</label
                    >
                    <multiselect
                        name="question_type"
                        v-model="form.question_type"
                        :options="['obj']"
                    />
                </div>
                <div class="mb-4">
                    <label for="question" class="text-sm text-gray-500">
                        Question</label
                    >
                    <ckeditor
                        id="question"
                        :editor="editor"
                        v-model="form.question"
                        :config="editorConfig"
                    ></ckeditor>
                </div>

                <table class="w-full divide-y divide-gray-200 table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="align-middle px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Question Tag
                            </th>
                            <th
                                class="align-middle px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Question
                            </th>
                            <th
                                class="align-middle px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Is Correct
                            </th>
                            <th
                                class="align-middle px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(opt, i) in options" :key="i + 'option'">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ opt.question_tag }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ opt.description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ opt.is_correct.label }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <i
                                    class="fa fa-trash text-danger-400 mr-3 cursor:pinter"
                                    @click="removeOption(i)"
                                ></i>
                                <i
                                    class="fa fa-edit"
                                    @click="editOption(i)"
                                ></i>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <Button
                    label="Add Options"
                    icon="fa fa-plus"
                    size="md"
                    class="mt-4"
                    @click="isAvatarModalShowing = true"
                    type="button"
                />

                <Modal
                    :is-showing="isAvatarModalShowing"
                    @close="isAvatarModalShowing = false"
                >
                    <div class="mb-4">
                        <label for="article-body" class="text-sm text-gray-500">
                            Question Tag</label
                        >
                        <multiselect
                            name="question_tag"
                            v-model="option.question_tag"
                            :options="['A', 'B', 'C', 'D', 'E']"
                        />
                    </div>

                    <TextInput
                        class="mb-4"
                        type="textarea"
                        name="description"
                        v-model="option.description"
                        :label="trans('Description')"
                    />

                    <div class="mb-4">
                        <label for="is_correct" class="text-sm text-gray-500">
                            Is Option correct? Yes/No</label
                        >
                        <multiselect
                            name="is_correct"
                            track-by="label"
                            v-model="option.is_correct"
                            label="label"
                            :options="[
                                {
                                    label: 'Yes',
                                    value: true,
                                },
                                {
                                    label: 'No',
                                    value: false,
                                },
                            ]"
                        />
                    </div>

                    <Button type="button" label="Add" @click="setOption()" />
                </Modal>
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
        const form = reactive({});
        const options = ref([]);

        let option = ref({
            question_tag: "",
            description: "",
            is_correct: "",
        });
        const isAvatarModalShowing = ref(false);

        const editorConfig = reactive({});
        const editor = reactive(ClassicEditor);

        const page = reactive({
            id: "create_question",
            title: trans("New Question"),
            filters: false,
            breadcrumbs: [
                {
                    name: trans("Course"),
                    to: toUrl("/course/list"),
                },
                {
                    name: "Lesson",
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

        function setOption() {
            const hasValue = options.value.find(
                (val) =>
                    val.question_tag === option.value.question_tag ||
                    (val.is_correct.value == true &&
                        option.value.is_correct.value)
            );
            const isEmpty = Object.values(option.value).find(
                (val) => val === ""
            );
            if (hasValue || isEmpty) return;

            options.value.push(option.value);
            isAvatarModalShowing.value = false;
            option.value = {};
        }

        function removeOption(i) {
            options.value.splice(i, 1);
        }

        function editOption(i) {
            let option = options.value.find((_, index) => index == i);

            option.value = option;
            isAvatarModalShowing.value = true;
        }

        function updateOption() {}

        function onSubmit() {
            form.lesson_id = route.params.id;
            form.options = JSON.stringify(options.value);
            service
                .handleCreateQuestion("create_question", reduceProperties(form))
                .then(() => {
                    router.push({
                        name: "course.lesson.list",
                        params: { id: route.params.id },
                    });
                    // clearObject(form);
                });
            course / 9 / lessons;
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
            options,
            option,
            setOption,
            removeOption,
            editOption,
            updateOption,
        };
    },
});
</script>

<style lang="scss" scoped>
.fa {
    font-size: 20px;
}
</style>
