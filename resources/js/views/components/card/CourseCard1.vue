<template>
    <div class="contain">
        <div class="wrapper">
            <div class="display">
                <img src="/assets/images/course2.jpg" alt="" />
            </div>
            <div class="content">
                <div class="flex my-3">
                    <div class="flex items-center gap-2 mr-4">
                        <i class="fa fa-list-alt"></i>
                        <span class="text-sm">13 Lesson</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa fa-list-alt"></i>
                        <span class="text-sm">12 Hours</span>
                    </div>
                </div>

                <div class="info">
                    <h4>Learning The way of the spirit</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut labore...
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {};
</script>

<style lang="scss">
.contain {
    box-shadow: 0 10px 30px rgb(0 0 0 / 6%);
    background: #fff;
    border-radius: 5px;
    width: 260px;
    padding: 15px;
    margin: 10px 0px;

    .content {
        span {
            color: #6f6b80;
            font-weight: 500;
        }
    }

    .info {
        h4 {
            font-size: 18px;
            font-weight: 600;
        }

        p {
            font-weight: 500;
            font-size: 14px;
            line-height: 22px;
            margin-bottom: 5px;
            color: #6f6b80;
            margin: 10px 0px;
        }
    }
}
</style>
