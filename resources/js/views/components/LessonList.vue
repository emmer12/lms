<template>
    <div
        v-if="type == 'certificate'"
        class="lesson-list-con flex items-center justify-between px-5 p-4 bg-[#f9fafc] my-2"
    >
        <div class="flex items-center">
            <Certificate />
            <h4 class="ml-4 font-medium text-[#6f6b80]">Certificate</h4>
        </div>
        <div class="a-status">
            <div>
                <div v-if="certificate_eligible" @click="download()">
                    <Download />
                </div>
                <div v-else>
                    <Lock />
                </div>
            </div>
        </div>
    </div>
    <div
        v-else
        class="lesson-list-con flex items-center justify-between px-5 p-4 bg-[#f9fafc] my-2"
        :class="{ active: lesson.id == $route.params.lesson_id }"
        @click="handleSelect(lesson.id)"
    >
        <div class="flex items-center">
            <FileList />
            <h4 class="ml-4 font-medium text-[#6f6b80]">
                {{ lesson.title }}
            </h4>
        </div>
        <div class="a-status">
            <div>
                <div v-if="canView()">
                    <Eye />
                </div>
                <div v-else>
                    <Lock />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Lock from "@/views/components/icons/Lock.vue";
import FileList from "@/views/components/icons/FileList.vue";
import Download from "@/views/components/icons/Download.vue";
import Certificate from "@/views/components/icons/Certificate.vue";
import Eye from "@/views/components/icons/Eye.vue";
import { useRouter, useRoute } from "vue-router";
import CourseService from "@/services/CourseService";
import { ref, onMounted } from "vue";
import { useBus } from "@/hooks";
import { useAlertStore } from "@/stores/alert";

export default {
    props: [
        "lesson",
        "currentLesson",
        "index",
        "completed",
        "next_id",
        "type",
        "certificate_eligible",
    ],
    components: {
        FileList,
        Lock,
        Eye,
        Certificate,
        Download,
    },
    setup(props, { emit }) {
        const router = useRouter();
        const route = useRoute();
        const downloading = ref(false);
        const service = new CourseService();
        const { bus } = useBus();
        const alertStore = useAlertStore();

        function handleSelect(id) {
            if (canView()) {
                emit("selected", id);

                router.push({
                    name: "my.learning.lesson",
                    params: { lesson_id: id },
                });
            }
        }

        function canView() {
            console.log(props.lesson.id, props.next_id);
            return (
                props.index == 0 ||
                props.completed.includes(props.lesson.id) ||
                props.next_id == props.lesson.id
            );
        }

        const download = async () => {
            const course_id = route.params.id;

            downloading.value = true;
            try {
                await service.downloadCertificate(course_id);
                alertStore.success("Congratulations!");

                router.push("/courses");

                downloading.value = false;
            } catch (err) {
                downloading.value = false;
            }
        };

        onMounted(() => {
            bus.on("download_certificate", () => {
                download();
            });
        });

        return { handleSelect, canView, download };
    },
};
</script>

<style lang="scss" scoped>
.lesson-list-con {
    cursor: pointer;
    svg {
        height: 16px !important;
        width: 16px !important;
    }

    &.active {
        background: #e1eaf8;
    }
}
</style>
