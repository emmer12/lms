<template>
    <div class="material-list-con px-5 p-2 bg-[#f9fafc] my-2 rounded">
        <div @click="setOpen()" class="flex mb-2 justify-between items-center">
            <div class="flex items-center gap-3">
                <div
                    class="flex items-center bg-white rounded-full h-12 w-12 justify-center"
                >
                    <Audio v-if="material.content_type == 'audio'" />
                    <Video v-else-if="material.content_type == 'video'" />
                    <FileList v-else />
                </div>
                <div class="a-status">
                    {{ material.title }}
                </div>
            </div>
            <div class="caret">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                    />
                </svg>
            </div>
        </div>
        <transition
            @before-enter="beforeEnter"
            @enter="enter"
            @leave="leave"
            name="toggle"
        >
            <div v-if="open" class="m-content">
                <audio
                    v-if="material.content_type == 'audio'"
                    controls
                    :src="material.full_path"
                ></audio>

                <div v-if="material.content_type == 'video'">
                    <div v-if="material.source == 'upload'">
                        <video controls :src="material.full_path"></video>
                    </div>
                    <div v-else>
                        <div v-html="material.embed_code"></div>
                    </div>
                </div>
                <div
                    class="inline-flex px-3 rounded-lg items-center gap-3 text-theme-800 bg-theme-100 text-sm font-bold"
                    v-if="material.content_type == 'doc'"
                >
                    <a :href="material.full_path" download
                        >{{ material.title }}
                    </a>
                    <Download />
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import Lock from "@/views/components/icons/Lock.vue";
import FileList from "@/views/components/icons/FileList.vue";
import Eye from "@/views/components/icons/Eye.vue";
import Audio from "@/views/components/icons/Audio.vue";
import Download from "@/views/components/icons/Download.vue";
import Video from "@/views/components/icons/Video.vue";
import { useRouter } from "vue-router";
import { ref, onMounted } from "vue";
import gsap from "gsap";

export default {
    props: ["material"],
    components: {
        FileList,
        Lock,
        Eye,
        Audio,
        Video,
        Download,
    },
    setup(props, { emit }) {
        const router = useRouter();
        const open = ref(false);

        const setOpen = () => {
            open.value = !open.value;
        };

        const beforeEnter = (el) => {
            el.style.opacity = 0;
        };
        const enter = (el, done) => {
            gsap.to(el, {
                opacity: 1,
                duration: 0.4,
                onComplete: done,
            });
        };
        const leave = (el, done) => {
            gsap.to(el, {
                opacity: 0,
                duration: 0.4,
                onComplete: done,
            });
        };

        onMounted(() => {});

        return {
            setOpen,
            open,
            beforeEnter,
            enter,
            leave,
        };
    },
};
</script>

<style lang="scss" scoped>
.material-list-con {
    cursor: pointer;
    svg {
        height: 16px !important;
        width: 16px !important;
    }

    .caret {
        svg {
            height: 20px !important;
            width: 20px !important;
        }
    }
}
</style>
