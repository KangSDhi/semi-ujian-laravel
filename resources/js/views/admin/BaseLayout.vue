<template>
    <div>
        <section>
            <button @click="toggleSidebar" type="button"
                class="inline-flex items-center p-2 mt-2 ml-3 text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                    </path>
                </svg>
            </button>
            <aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform" :class="sidebarComputed">
                <div class="h-full px-3 py-4 bg-gray-50 dark:bg-gray-800">
                    <a href="#" class="flex items-center pl-2.5 mb-5">
                        <img src="../../../../public/img/logo.webp" class="h-5 mr-3 sm:h-7" alt="Ujian Logo" />
                        <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">LMS
                            Ujian</span>
                    </a>
                    <button @click="toggleSidebar" type="button"
                        class="sm:invisible text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close menu</span>
                    </button>
                    <ul>
                        <li>
                            <router-link :to="{ name: 'Dashboard Admin' }"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                <span class="ml-3">Dashboard</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'Data Siswa Admin' }"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                                <span class="ml-3">Data Siswa</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{}"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                </svg>
                                <span class="ml-3">Data Soal</span>
                            </router-link>
                        </li>
                        <li>
                            <a @click="isLogoutOpen = true"
                                class="flex items-center mt-2 p-2 text-gray-900 rounded-lg bg-red-400 dark:text-white hover:bg-red-500 dark:hover:bg-red-500 group cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Keluar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>
            <main class="p-4 sm:ml-64">
                <slot name="content"></slot>
            </main>
        </section>
    </div>
    <div v-show="isLogoutOpen"
        class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
        <div class="bg-white px-16 py-14 rounded-md text-center">
            <h1 class="text-xl mb-4 font-bold text-slate-500">Apakah Anda Ingin Keluar?</h1>
            <div class="grid grid-cols-2 gap-1">
                <button @click="logout"
                    class="bg-red-500 px-4 py-2 rounded-md text-md font-semibold text-white cursor-pointer">Keluar</button>
                <button @click="isLogoutOpen = false"
                    class="bg-gray-500 px-4 py-2 rounded-md text-md font-semibold text-white ml-1 cursor-pointer">Batal</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            token: localStorage.getItem("auth_token"),
            isSidebarOpen: false,
            isLogoutOpen: false,
        }
    },
    computed: {
        sidebarComputed() {
            return this.isSidebarOpen ? '' : '-translate-x-full sm:translate-x-0';
        }
    },
    mounted() {
        this.checkAuth();
    },
    methods: {
        toggleSidebar() {
            this.isSidebarOpen = !this.isSidebarOpen
        },
        logout() {
            axios.get("/api/admin/logout", {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
                    localStorage.removeItem("auth_token");
                    this.$router.push({ name: "Login Page" })
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        checkAuth() {
            axios.get("/api/check/auth", {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
                    if (data.data.role_id != 1) {
                        localStorage.removeItem("auth_token");
                        this.$router.push({ name: "Login Page" });
                    }
                })
                .catch(({ response }) => {
                    console.error(response.status);
                    if (response.status == 401) {
                        localStorage.removeItem("auth_token");
                        this.$router.push({ name: "Login Page" });
                    }
                });
        }
    }
}
</script>