<template>
    <footer>
        <div class="container-x">
            <div class="wrapper flex flex-wrap">
                <div class="flex-1 details">
                    <div class="flex gap-10 flex-wrap">
                        <div class="flex-1">
                            <!-- <img src="" alt="" /> -->
                            <img class="mt-4" src="/assets/images/logo.png" />

                            <!-- <p>© Copyright RCCG E 2022</p> -->
                            <p class="mt-3">(480) 555-0103</p>
                            <p>4517 Washington Ave.</p>
                            <p>finsweet@example.com</p>
                        </div>
                        <div class="flex gap-10">
                            <div>
                                <h4 class="heading">Quick link</h4>
                                <ul>
                                    <router-link to="#" v-slot="{ navigate }">
                                        <li @click="navigate">About Us</li>
                                    </router-link>
                                    <router-link to="#" v-slot="{ navigate }">
                                        <li @click="navigate">Sermons</li>
                                    </router-link>
                                    <router-link to="#" v-slot="{ navigate }">
                                        <li @click="navigate">Events</li>
                                    </router-link>
                                </ul>
                            </div>
                            <div>
                                <h4 class="heading">Connect</h4>
                                <div class="flex gap-4 mt-3">
                                    <a href="#">
                                        <svg
                                            width="16"
                                            height="16"
                                            viewBox="0 0 16 16"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M16 8C16 3.58172 12.4183 0 8 0C3.58172 0 0 3.58172 0 8C0 11.993 2.92547 15.3027 6.75 15.9028V10.3125H4.71875V8H6.75V6.2375C6.75 4.2325 7.94438 3.125 9.77172 3.125C10.6467 3.125 11.5625 3.28125 11.5625 3.28125V5.25H10.5538C9.56 5.25 9.25 5.86672 9.25 6.5V8H11.4688L11.1141 10.3125H9.25V15.9028C13.0745 15.3027 16 11.993 16 8Z"
                                                fill="#6541e6"
                                            />
                                        </svg>
                                    </a>

                                    <a href="#">
                                        <svg
                                            width="16"
                                            height="16"
                                            viewBox="0 0 16 16"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <g clip-path="url(#clip0_1018_271)">
                                                <path
                                                    d="M5.03344 14.5C11.0697 14.5 14.3722 9.4978 14.3722 5.16124C14.3722 5.02062 14.3691 4.87687 14.3628 4.73624C15.0052 4.27164 15.5597 3.69617 16 3.03687C15.4017 3.30307 14.7664 3.47692 14.1159 3.55249C14.8009 3.14194 15.3137 2.49698 15.5594 1.73718C14.915 2.11904 14.2104 2.38841 13.4756 2.53374C12.9806 2.00771 12.326 1.65941 11.6131 1.5427C10.9003 1.42599 10.1688 1.54737 9.53183 1.88806C8.89486 2.22876 8.38787 2.7698 8.08923 3.42754C7.7906 4.08528 7.71695 4.82308 7.87969 5.52687C6.575 5.46139 5.29862 5.12247 4.13332 4.53207C2.96802 3.94166 1.9398 3.11296 1.11531 2.09968C0.696266 2.82216 0.568038 3.6771 0.756687 4.49073C0.945337 5.30436 1.43671 6.01563 2.13094 6.47999C1.60975 6.46344 1.09998 6.32312 0.64375 6.07062V6.11124C0.643283 6.86943 0.905399 7.60439 1.38554 8.19118C1.86568 8.77797 2.53422 9.18037 3.2775 9.32999C2.7947 9.46209 2.28799 9.48133 1.79656 9.38624C2.0063 10.0383 2.41438 10.6086 2.96385 11.0176C3.51331 11.4265 4.17675 11.6537 4.86156 11.6675C3.69895 12.5807 2.26278 13.0761 0.784375 13.0737C0.522191 13.0733 0.260266 13.0573 0 13.0256C1.5019 13.9892 3.24902 14.5009 5.03344 14.5Z"
                                                    fill="#6541e6"
                                                />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_1018_271">
                                                    <rect
                                                        width="16"
                                                        height="16"
                                                        fill="white"
                                                    />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>

                                    <a href="#">
                                        <svg
                                            width="16"
                                            height="16"
                                            viewBox="0 0 16 16"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <g clip-path="url(#clip0_1018_273)">
                                                <path
                                                    d="M14.8156 0H1.18125C0.528125 0 0 0.515625 0 1.15313V14.8438C0 15.4813 0.528125 16 1.18125 16H14.8156C15.4688 16 16 15.4813 16 14.8469V1.15313C16 0.515625 15.4688 0 14.8156 0ZM4.74687 13.6344H2.37188V5.99687H4.74687V13.6344ZM3.55938 4.95625C2.79688 4.95625 2.18125 4.34062 2.18125 3.58125C2.18125 2.82188 2.79688 2.20625 3.55938 2.20625C4.31875 2.20625 4.93437 2.82188 4.93437 3.58125C4.93437 4.3375 4.31875 4.95625 3.55938 4.95625ZM13.6344 13.6344H11.2625V9.92188C11.2625 9.0375 11.2469 7.89687 10.0281 7.89687C8.79375 7.89687 8.60625 8.8625 8.60625 9.85938V13.6344H6.2375V5.99687H8.5125V7.04063H8.54375C8.85938 6.44063 9.63438 5.80625 10.7875 5.80625C13.1906 5.80625 13.6344 7.3875 13.6344 9.44375V13.6344Z"
                                                    fill="#6541e6"
                                                />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_1018_273">
                                                    <rect
                                                        width="16"
                                                        height="16"
                                                        fill="white"
                                                    />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-1 sub">
                    <h2>
                        Subscribe to get Latest <br />
                        Updates and News
                    </h2>
                    <div class="flex align-end">
                        <input type="text" />
                        <Button label="Subscribe" />
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
footer {
    padding: 50px 0px;
    background: #161722;
    color: rgba(255, 255, 255, 0.78);

    .details {
        /* margin-right: 115px; */

        p {
            font-size: 12px;
            padding: 10px 0px;

            &:nth-child(1) {
                padding: 20px 0px;
            }
        }
    }

    .sub {
        padding-left: 115px;

        > div {
            align-items: flex-end;
        }
        h2 {
            font-weight: 700;
            font-size: 32px;
            line-height: 44px;
            /* or 138% */

            letter-spacing: -0.01em;
            text-transform: uppercase;
        }

        input {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            height: 58px;
            margin-top: 32px;
            flex: 1;
            max-width: 300px;
        }

        button {
            border-top-left-radius: 0px;
            border-bottom-left-radius: 0px;
            margin-left: -10px;
            height: 58px;
        }
    }

    ul {
        li {
            text-transform: uppercase;
            padding: 10px 0px;
            font-size: 12px;
        }
    }

    .heading {
        color: #fff;
    }
}

@media (max-width: 640px) {
    footer {
        .sub {
            padding-left: 0px;

            h2 {
                font-size: 20px;
                line-height: 32px;
            }
        }
    }
}
</style>
