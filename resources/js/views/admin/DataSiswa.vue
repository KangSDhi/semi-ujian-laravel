<template>
    <BaseLayout>
        <template #content>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3">
                                NISN
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Siswa
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jurusan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Password
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(item, index) in items" :key="index">
                            <tr v-show="checkView(index + 1)"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ index + 1 }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ item.nisn }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.nama_siswa }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.nama_jurusan }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ item.password_dec }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="#"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Aksi</a>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="flex items-center -space-x-px h-8 text-sm">
                        <li>
                            <a href="#"
                                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 1 1 5l4 4" />
                                </svg>
                            </a>
                        </li>
                        <template v-for="(item, index) in pagination.pages" :key="index">
                            <li>
                                <div
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    {{ item }}
                                </div>
                            </li>
                        </template>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </template>
    </BaseLayout>
</template>

<script>
import BaseLayout from './BaseLayout.vue';
import axios from 'axios';
import Fuse from "fuse.js";

export default {
    data() {
        return {
            token: localStorage.getItem("auth_token"),
            data: [],
            items: [],
            listView: [10, 25, 50, 100],
            view: 10,
            searchInput: '',
            pagination: {
                pages: [],
                total: 0,
                lastPage: 0,
                perPage: 5,
                currentPage: 1,
                offset: 5,
                from: 1,
                to: 10
            },
            sorted: {
                field: 'nama_jurusan',
                rule: 'asc'
            }
        }
    },
    components: {
        BaseLayout
    },
    mounted() {
        this.getSiswa()
    },
    methods: {
        getSiswa() {
            axios.get("/api/admin/data-siswa", {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
                    console.log(data);
                    this.items = this.data = data.data;
                    this.pagination.lastPage = Math.ceil(data.data.length / this.view);
                    this.pagination.total = data.data.length;

                    this.showPages();
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        checkView(index) {
            return index > this.pagination.to || index < this.pagination.from ? false : true;
        },
        showPages(){
            const pages = [];
            let from = this.pagination.currentPage - Math.ceil(this.pagination.offset / 2);

            if (from < 1) {
                from = 1;
            }

            let to = from + this.pagination.offset - 1;

            if (to > this.pagination.lastPage) {
                to = this.pagination.lastPage;
            }

            while(from <= to){
                pages.push(from);
                from++;
            }

            this.pagination.pages = pages;
        }
    }
}
</script>