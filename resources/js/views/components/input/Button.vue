<template>
    <router-link v-if="$props.to" :class="classes" :to="$props.to">
        <template v-if="$props.icon"
            ><i class="mr-1" :class="$props.icon"></i
        ></template>
        {{ $props.label }}
        <template v-if="$props.iconRight"
            ><i class="ml-1" :class="$props.iconRight"></i
        ></template>
    </router-link>
    <button
        v-else
        :type="type"
        :class="classes"
        @click="onClick"
        :disabled="disabled"
    >
        <template v-if="$props.icon"
            ><i class="mr-1" :class="$props.icon"></i
        ></template>
        {{ $props.label }}
        <template v-if="$props.iconRight"
            ><i class="ml-1" :class="$props.iconRight"></i
        ></template>
    </button>
</template>

<script>
import { computed, defineComponent } from "vue";

export default defineComponent({
    props: {
        label: {
            type: String,
            default: "Submit",
        },
        type: {
            type: String,
            default: "submit",
        },
        icon: {
            type: String,
            default: "",
        },
        iconRight: {
            type: String,
            default: "",
        },
        class: {
            type: String,
            default: "",
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        theme: {
            type: String,
            default: "",
        },
        to: {
            type: String,
            default: null,
        },
        size: {
            type: String,
            default: "",
        },
    },
    emits: ["click"],
    setup(props, { emit }) {
        function onClick(event) {
            emit("click", event);
        }

        const classes = computed(() => {
            let value =
                "border border-transparent rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 text-center transition ";
            switch (props.theme) {
                case "success":
                    value +=
                        "text-white bg-green-600 hover:bg-green-800 focus:bg-green-800 focus:ring-green-800";
                    break;
                case "info":
                    value +=
                        "text-white bg-blue-600 hover:bg-blue-800 focus:bg-blue-800 focus:ring-blue-800";
                    break;
                case "warning":
                    value +=
                        "text-white bg-orange-600 hover:bg-orange-800 focus:bg-orange-800 focus:ring-orange-800";
                    break;
                case "danger":
                case "error":
                    value +=
                        "text-white bg-red-600 hover:bg-red-800 focus:bg-red-800 focus:ring-red-800";
                    break;
                case "outline":
                    value +=
                        "text-theme-600 border-2 border-theme-500 border-solid hover:bg-theme-800 hover:text-white hover:border-transparent";
                    break;
                default:
                    value +=
                        "text-white bg-theme-500 hover:bg-theme-600 focus:bg-theme-700 focus:ring-theme-800 disabled:bg-theme-200";
                    break;
            }

            switch (props.size) {
                case "lg":
                    value += " px-6 py-3 text-md";
                    break;
                case "md":
                    value += " px-4 py-2 text-md";
                    break;
                case "sm":
                    value += " px-5 py-2 text-sm";
                    break;
                case "xs":
                    value += " px-3 py-1 text-xs";
                    break;
                default:
                    value += " px-6 py-3 text-md";
                    break;
            }

            if (props.class) {
                value += " " + props.class;
            }

            return value;
        });

        return {
            onClick,
            classes,
        };
    },
});
</script>
