<template>
    <div
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
                <div v-if="canView()">Preview</div>
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

export default {
    props: ["lesson", "currentLesson", "index", "completed", "next_id"],
    components: {
        FileList,
        Lock,
    },
    setup(props, { emit }) {
        function handleSelect(id) {
            if (canView()) {
                emit("selected", id);
            }
        }

        function canView() {
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
