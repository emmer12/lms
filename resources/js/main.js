import { createApp } from "vue";
import { createPinia } from "pinia";

import router from "@/router";
import i18n from "@/plugins/i18n";
import App from "@/App";
import Button from "@/views/components/input/Button";
import Logo from "@/views/components/Logo";
import CourseCard1 from "@/views/components/card/CourseCard1";
import CourseCard4 from "@/views/components/card/CourseCard4";
import CourseCard from "@/views/components/card/CourseCard";
import Header from "@/views/components/Header";
import CKEditor from "@ckeditor/ckeditor5-vue";
import Vue3ConfirmDialog from "vue3-confirm-dialog";
import "vue3-confirm-dialog/style";
const app = createApp(App);

app.use(Vue3ConfirmDialog);
app.component("vue3-confirm-dialog", Vue3ConfirmDialog.default);
app.component("Button", Button);
app.component("Logo", Logo);
app.component("CourseCard", CourseCard);
app.component("CourseCard1", CourseCard1);
app.component("CourseCard4", CourseCard4);
app.component("Header", Header);

app.use(CKEditor);
app.use(createPinia());

app.use(router);
app.use(i18n);

app.mount("#app");
