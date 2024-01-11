<template>
    <BaseLayout>
        <template #content>
            <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <svg id="Layer_2" class="mx-auto h-24 w-auto fill-blue-500" data-name="Layer 2"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                        <title>Online course</title>
                        <path class="cls-1"
                            d="M52.46,40.28V12.8a3.3,3.3,0,0,0-3.3-3.3H14.84a3.3,3.3,0,0,0-3.3,3.3V40.28a3.3,3.3,0,0,0,3.3,3.3H26.38c-.17,3.7-1.63,5-2.14,5.4H21.91a2.76,2.76,0,0,0,0,5.52H42.09a2.76,2.76,0,0,0,0-5.52H39.76c-.49-.35-2-1.7-2.14-5.4H49.16A3.3,3.3,0,0,0,52.46,40.28ZM14.84,11.5H49.16a1.3,1.3,0,0,1,1.3,1.3V34.61H13.54V12.8A1.3,1.3,0,0,1,14.84,11.5Zm-1.3,28.78V36.61H50.46v3.67a1.3,1.3,0,0,1-1.3,1.3H14.84A1.3,1.3,0,0,1,13.54,40.28ZM42.85,51.74a.76.76,0,0,1-.76.76H21.91a.76.76,0,0,1,0-1.52H24.4l.1,0,.06,0H39.44l.06,0,.1,0h2.49A.76.76,0,0,1,42.85,51.74ZM37.12,49H26.88a10.66,10.66,0,0,0,1.5-5.4h7.24A10.66,10.66,0,0,0,37.12,49Z" />
                        <path class="cls-1" d="M33.5,37.75h-3a1,1,0,0,0,0,2h3a1,1,0,0,0,0-2Z" />
                        <path class="cls-1"
                            d="M20.16,19.5a.68.68,0,0,0,0,.14l0,0a.67.67,0,0,0,.11.18,1.7,1.7,0,0,0,.1.14.71.71,0,0,0,.14.1,1.22,1.22,0,0,0,.19.12h0l1.52.58V28a1.42,1.42,0,0,0,.87,1.33l7.07,2.93a4.58,4.58,0,0,0,3.56,0l7.07-2.93A1.42,1.42,0,0,0,41.72,28V20.8l1.35-.51h1.57v1.62a.29.29,0,0,0,0,.09l-.65.73a1,1,0,0,0,.08,1.41,1,1,0,0,0,1.42-.08l.13-.15.13.15a1,1,0,1,0,1.49-1.33L46.62,22s0-.06,0-.09V19.29a1,1,0,0,0-1-1H43.07l-10.72-4a.94.94,0,0,0-.7,0l-10.89,4.1,0,0-.17.11a.83.83,0,0,0-.15.11.43.43,0,0,0-.09.13.55.55,0,0,0-.12.19s0,0,0,0a.59.59,0,0,0,0,.14.57.57,0,0,0,0,.42Zm19.56,8.13L33,30.42a2.62,2.62,0,0,1-2,0l-6.71-2.79V21.55L31,24.08v3.23a1,1,0,1,0,2,0V24.08l6.72-2.53ZM32,16.25l5.4,2H32a1,1,0,0,0,0,2h5.4l-5.4,2-8-3Z" />
                    </svg>
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                        Silahkan Masuk
                    </h2>
                </div>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form class="space-y-6" @submit.prevent="login()">
                        <div>
                            <label class="block text-sm font-medium leading-6 text-gray-900">
                                Email / NISN
                            </label>
                            <div class="mt-2">
                                <input v-model="emailOrNisn" type="text"
                                    class="block w-full rounded-md border-0 py-1.5 px-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6"
                                    :class="{
                                        'border-2 border-rose-200':
                                            isEmailError,
                                    }" />
                            </div>
                            <span class="text-rose-500 text-sm font-bold">{{
                                emailErrorMessage
                            }}</span>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                <div class="text-sm">
                                    <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">
                                        Lupa Password?
                                    </a>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input v-model="password" type="password"
                                    class="block w-full rounded-md border-0 py-1.5 px-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6"
                                    :class="{
                                        'border-2 border-rose-200':
                                            isPasswordError,
                                    }" />
                            </div>
                            <span class="text-rose-500 text-sm font-bold">{{ passwordErrorMessage }}
                            </span>
                        </div>

                        <div>
                            <button type="submit"
                                class="flex w-full justify-center rounded-md bg-gradient-to-tr from-blue-600 to-blue-400 shadow-blue-500/20 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Masuk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div v-show="isAuthError" class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
                <div class="bg-white px-16 py-14 rounded-md text-center">
                    <h1 class="text-xl mb-4 font-bold text-slate-500">Galat!</h1>
                    <h3 class="text-lg mb-4 font-semibold text-gray-800">{{ authErrorMessage }}</h3>
                    <button @click="isAuthError = false" class="bg-red-500 px-4 py-2 rounded-md text-md font-semibold text-white">Ok</button>
                </div>
            </div>
        </template>
    </BaseLayout>
</template>

<script>
import BaseLayout from "./BaseLayout.vue";
import axios from "axios";

export default {
    components: {
        BaseLayout,
    },
    data() {
        return {
            emailOrNisn: "",
            password: "",
            isEmailError: false,
            isPasswordError: false,
            emailErrorMessage: "",
            passwordErrorMessage: "",
            isAuthError: false,
            authErrorMessage: "",
        };
    },
    mounted() {
        // this.testAPI();
    },
    methods: {
        testAPI() {
            axios
                .get("/api/test")
                .then((response) => {
                    console.log(response);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        login() {
            axios
                .post("/api/login", {
                    emailOrNisn: this.emailOrNisn,
                    password: this.password,
                })
                .then(({ data }) => {
                    console.log(data);
                })
                .catch(({ response }) => {
                    console.error(response);
                    if (response.status == 422) {
                        const errorMessages = response.data.errors;
                        Object.keys(errorMessages).forEach((key) => {
                            if (key == "emailOrNisn") {
                                this.isEmailError = true;
                                this.emailErrorMessage = errorMessages[key][0];
                            }

                            if (key == "password") {
                                this.isPasswordError = true;
                                this.passwordErrorMessage =
                                    errorMessages[key][0];
                            }
                        });
                    } else if (response.status == 401) {
                        const errorMessage = response.data.error;
                        this.isAuthError = true;
                        this.authErrorMessage = errorMessage;
                    }
                });
        },
    },
};
</script>
