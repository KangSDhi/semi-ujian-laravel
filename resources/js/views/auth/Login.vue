<template>
    <BaseLayout>
        <template #content>
            <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <img src="../../../../public/img/logo.webp" class="mx-auto h-24 w-auto" alt="Ujian Logo">
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                        Silahkan Masuk
                    </h2>
                </div>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form class="space-y-6" @submit.prevent="login()">
                        <div>
                            <label class="block text-sm font-medium leading-6 text-gray-900">
                                Email / ID Peserta
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
                            <label class="block text-sm font-medium leading-6 text-gray-900">
                                Password
                            </label>
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
            <div v-show="isAuthError"
                class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
                <div class="bg-white px-16 py-14 rounded-md text-center">
                    <h1 class="text-xl mb-4 font-bold text-slate-500">Galat!</h1>
                    <h3 class="text-lg mb-4 font-semibold text-gray-800">{{ authErrorMessage }}</h3>
                    <button @click="isAuthError = false"
                        class="bg-red-500 px-4 py-2 rounded-md text-md font-semibold text-white">Ok</button>
                </div>
            </div>
            <LoadingComponent v-show="isLoading" />
        </template>
    </BaseLayout>
</template>

<script>
import BaseLayout from "./BaseLayout.vue";
import LoadingComponent from "../../components/auth/LoadingComponent.vue";
import axios from "axios";

export default {
    components: {
        BaseLayout,
        LoadingComponent,
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
            isLoading: false,
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
            this.resetForm();

            const postData = async () => {
                const promise = axios
                    .post("/api/login", {
                        emailOrNisn: this.emailOrNisn,
                        password: this.password,
                    });

                this.isLoading = true;

                try {
                    const response = await promise;
                    console.log(response.data.data.user.role_id);
                    localStorage.setItem("auth_token", response.data.data.token);
                    if (response.data.data.user.role_id == 1) {
                        this.$router.push({ name: "Dashboard Admin" });
                    } else if (response.data.data.user.role_id == 2) {
                        this.$router.push({ name: "Dashboard Siswa" });
                    }
                } catch ({ response }) {
                    this.isLoading = false;
                    const errorMessages = response.data.error_message;
                    if (this.isObject(errorMessages)) {
                        Object.keys(errorMessages).forEach((key) => {
                            if (key == "emailOrNisn") {
                                this.isEmailError = true;
                                this.emailErrorMessage = errorMessages[key][0];
                            }

                            if (key == "password") {
                                this.isPasswordError = true;
                                this.passwordErrorMessage = errorMessages[key][0];
                            }
                        });
                    } else {
                        this.isAuthError = true;
                        this.authErrorMessage = errorMessages;
                    }
                }
            }

            postData();
        },
        isObject(value) {
            return (
                typeof value === 'object' && value !== null && !Array.isArray(value)
            );
        },
        resetForm() {
            this.isEmailError = false;
            this.isPasswordError = false;
            this.emailErrorMessage = "";
            this.passwordErrorMessage = "";
        },
    },
};
</script>
