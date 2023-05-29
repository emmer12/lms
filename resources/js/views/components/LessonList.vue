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
                <div v-if="certificate_eligible">
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
import { useRouter } from "vue-router";

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

        return { handleSelect, canView };
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
}
</style>
