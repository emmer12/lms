<template>
    <div class="heading">
        <h4 class="text-theme-600">{{ subtitle }}</h4>
        <h2>{{ title }}</h2>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
        },
        subtitle: {
            type: String,
        },
    },
};
</script>

<style lang="scss" scoped>
.heading {
    text-align: center;
    h2 {
        margin-top: 5px;
        margin-bottom: 0;
        font-size: 40px;
        font-weight: 800;
    }
    h4 {
        font-size: 20px;
        text-transform: uppercase;
        font-weight: 700;
    }
}
</style>
