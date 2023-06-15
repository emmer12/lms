<template>
    <Page
        :title="page.title"
        :breadcrumbs="page.breadcrumbs"
        :actions="page.actions"
        @action="onAction"
        :is-loading="page.loading"
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
                    :required="true"
                    name="price"
                    v-model="form.price"
                    :label="trans('Price')"
                />
                <TextInput
                    class="mb-4"
                    type="text"
                    name="duration"
                    v-model="form.duration"
                    :label="trans('Duration')"
                />
                <FileInput
                    class="mb-4"
                    name="preview"
                    v-model="form.preview"
                    accept="image/*"
                    :label="trans('Preview')"
                    @click="form.preview = ''"
                ></FileInput>

                <label class="relative inline-flex items-center cursor-pointer">
                    <input
                        type="checkbox"
                        v-model="form.featured"
                        value=""
                        class="sr-only peer"
                    />
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-theme-600"
                    ></div>
                    <span
                        class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >Featured Course</span
                    >
                </label>

                <label
                    class="ml-4 relative inline-flex items-center cursor-pointer"
                >
                    <input
                        type="checkbox"
                        v-model="form.published"
                        true-value="1"
                        false-value="0"
                        value=""
                        class="sr-only peer"
                    />
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-theme-600"
                    ></div>
                    <span
                        class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >Publish</span
                    >
                </label>
            </Form>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, onBeforeMount, reactive, ref } from "vue";
import { trans } from "@/helpers/i18n";
import { fillObject, reduceProperties } from "@/helpers/data";
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { toUrl } from "@/helpers/routing";
import CourseService from "@/services/CourseService";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Dropdown from "@/views/components/input/Dropdown";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import Form from "@/views/components/Form";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

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
    },
    setup() {
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            title: "",
            description: "",
            price: "",
            duration: "",
            price: 0,
            preview: "",
            featured: 0,
            published: 0,
        });

        const page = reactive({
            id: "edit_course",
            title: trans("Edit Course"),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans("Courses"),
                    to: toUrl("/course/list"),
                },
                {
                    name: trans("Edit Course"),
                    active: true,
                },
            ],
            actions: [
                {
                    id: "back",
                    name: trans("global.buttons.back"),
                    icon: "fa fa-angle-left",
                    to: toUrl("/course/list"),
                    theme: "outline",
                },
                {
                    id: "submit",
                    name: trans("global.buttons.update"),
                    icon: "fa fa-save",
                    type: "submit",
                },
            ],
        });

        const service = new CourseService();

        const editorConfig = reactive({});
        const editor = reactive(ClassicEditor);

        onBeforeMount(() => {
            service.edit(route.params.id).then((response) => {
                fillObject(form, response.data.model);
                delete form.preview;
                page.loading = false;
            });
        });

        function onAction(data) {
            switch (data.action.id) {
                case "submit":
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleUpdate(
                "edit-course",
                route.params.id,
                reduceProperties(form)
            );
            return false;
        }

        return {
            trans,
            user,
            form,
            onSubmit,
            onAction,
            page,
            editorConfig,
            editor,
        };
    },
});
</script>

<style scoped></style>
