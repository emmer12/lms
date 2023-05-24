<template>
    <div class="app-d">
        <div class="container-x">
            <div class="flex">
                <div class="art flex-1">
                    <img src="/assets/images/app.png" alt="App" />
                </div>
                <div class="details flex-1">
                    <div class="flex">
                        <div class="icon"></div>
                        <div>
                            <h2>
                                Download the <br />
                                church app!
                            </h2>
                        </div>
                    </div>
                    <div class="">
                        <p class="my-10">
                            Enjoy live services, sermons, events, media library,
                            giving, and much more! Take Oaks Church in your
                            pocket wherever you go.
                        </p>

                        <div class="flex item-center">
                            <img
                                src="/assets/images/Apple Store.png"
                                alt="Apple Store"
                                class="mr-4"
                            />
                            <img
                                src="/assets/images/Playstore.png"
                                alt="Playstore"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.app-d {
    padding: 100px 0px;
}
.details {
    h2 {
        font-size: 56px;
        font-weight: 700;
        line-height: 58px;
    }

    p {
        font-size: 20px;
        color: rgba(0, 0, 0, 0.7);
    }
}
</style>
