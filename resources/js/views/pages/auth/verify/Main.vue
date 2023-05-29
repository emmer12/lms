<template>
    <div class="verify">
        <div
            class="w-[600px] max-w-full bg-white m-auto p-5 py-10 mt-[100px] rounded-sm"
        >
            <div class="text-center">
                <Check />
                <h2 class="text-xl font-bold mt-4">
                    Your account has been successfully created
                </h2>
            </div>
            <br />
            <div class="px-5">
                <h4 class="font-bold">Check Your email inbox</h4>
                <p>
                    We've sent a verification link to your email address
                    <b>{{ $route.query.email }} </b><br />
                    Please check your email inbox and verify email address.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import Check from "@/views/components/icons/Check";
export default {
    components: {
        Check,
    },
};
</script>

<style scoped lang="scss">
.verify {
    svg {
        margin: auto;
    }
}
</style>
