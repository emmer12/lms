<template>
    <div class="">
        <Alert class="mb-4" />
        <!-- <slot name="filters"></slot> -->
        <div class="grid grid-cols-1">
            <template v-if="isElementLoading">
                <div class="pt-10 pb-6 text-center">
                    <Spinner />
                </div>
            </template>
            <slot v-else></slot>
            <Footer />
        </div>
    </div>
</template>

<script>
import { computed, defineComponent } from "vue";
import { trans } from "@/helpers/i18n";
import { toUrl } from "@/helpers/routing";
import Button from "@/views/components/input/Button";
import Alert from "@/views/components/Alert";
import Footer from "@/views/components/Footer";
import Spinner from "@/views/components/icons/Spinner";
import { useGlobalStateStore } from "@/stores";
import { storeToRefs } from "pinia";

export default defineComponent({
    name: "Page",
    components: { Alert, Button, Spinner, Footer },
    props: {
        id: {
            type: String,
            default: "",
        },
        title: {
            type: String,
            default: "",
        },
        breadcrumbs: {
            type: Array,
            default: [],
        },
        actions: {
            type: Array,
            default: [],
        },
        isLoading: {
            type: Boolean,
            default: false,
        },
    },
    emits: ["action"],
    setup(props, { emit }) {
        function onPageActionClick(data) {
            emit("action", data);
        }

        const isElementLoading = computed(() => {
            return (
                useGlobalStateStore().loadingElements[props.id] ||
                props.isLoading
            );
        });

        return {
            trans,
            toUrl,
            onPageActionClick,
            isElementLoading,
        };
    },
});
</script>
