<template>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="justify-self-center sm:justify-self-start">
            <select id="view-data-table" v-model="view" @change="changeView()"
                class="block w-60 p-2 mb-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <template v-for="(item, index) in listViewBinding()">
                    <option :value="item">{{ item }}</option>
                </template>
            </select>
        </div>
        <div class="grid grid-cols-1">
            <button @click="formCreateSoalOpen"
                class="px-5 py-2 h-10 w-40 justify-self-center bg-blue-200 dark:bg-blue-400 hover:bg-blue-300 dark:hover:bg-blue-500 text-sm me-2 rounded-lg inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Soal
            </button>
        </div>
        <div class="justify-self-center mb-2 sm:justify-self-end">
            <label for="search-data-table"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input id="search-data-table" v-model="searchInput" type="search"
                    class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Cari ">
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Soal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jurusan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tingkat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Waktu Mulai
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Waktu Selesai
                    </th>
                    <th scope="col" class="px-6 py-3 text-end">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                <template v-if="items.length == 0">
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th class="text-xl text-center py-2.5" colspan="6">Data Kosong</th>
                    </tr>
                </template>
                <template v-for="(item, index) in items" :key="index">
                    <tr v-show="checkView(index + 1)"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ index + 1 }}
                        </th>
                        <td class="px-6 py-4">
                            {{ item.nama_soal }}
                        </td>
                        <td class="px-6 py-4">
                            <template v-if="item.nama_jurusan != null">
                                {{ item.nama_jurusan }}
                            </template>
                            <template v-else>
                                <span>Semua</span>
                            </template>
                        </td>
                        <td class="px-6 py-4">
                            {{ item.nama_tingkat }}
                        </td>
                        <td class="px-6 py-4">
                            {{ item.waktu_mulai }}
                        </td>
                        <td class="px-6 py-4">
                            {{ item.waktu_selesai }}
                        </td>
                        <td class="px-6 py-4 space-x-2 text-right">
                            <a :href="item.link" target="_blank"
                                class="bg-yellow-200 px-2.5 py-1 text-gray-900 rounded-md inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                </svg>
                                Link
                            </a>
                            <button @click="formEditSoalOpen(item.id)"
                                class="bg-blue-200 px-2.5 py-1 text-gray-900 rounded-md inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                Edit
                            </button>
                            <button @click="deleteDialogSoalOpen(item.id)"
                                class="px-2.5 py-1 text-red-500 rounded-md inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                                Hapus
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
    <nav aria-label="table navigation">
        <ul class="flex items-center -space-x-px h-10 text-base">
            <li>
                <button @click.prevent="clickPage(1)"
                    class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-bl-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    Awal
                </button>
            </li>
            <li>
                <button @click.prevent="clickPage(pagination.currentPage - 1)"
                    class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Previous</span>
                    <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                </button>
            </li>
            <template v-for="(item, index) in pagination.pages" :key="index">
                <li>
                    <button @click="clickPage(item)"
                        class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white hover:cursor-pointer"
                        :class="{ 'dark:bg-white dark:text-gray-800': pagination.currentPage === item }">
                        {{ item }}
                    </button>
                </li>
            </template>
            <li>
                <button @click.prevent="clickPage(pagination.currentPage + 1)"
                    class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Next</span>
                    <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </button>
            </li>
            <li>
                <button @click="clickPage(pagination.lastPage)"
                    class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-br-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    Akhir
                </button>
            </li>
        </ul>
    </nav>
</template>

<script>
import axios from "axios";
import Fuse from "fuse.js";

export default {
    name: "TabelSoal",
    emits: [
        "dataSoal",
        "isFormCreateSoalTrue",
        "isFormEditSoalTrue",
        "isDeleteDialogSoalTrue"
    ],
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
            },
        }
    },
    mounted() {
        this.getDataSoal();
    },
    watch: {
        searchInput: function(newVal, oldVal) {
            this.search(newVal);
        }
    },
    methods: {
        getDataSoal() {
            axios.get("/api/admin/soal", {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
                    this.items = this.data = data.data;
                    this.pagination.lastPage = Math.ceil(data.data.length / this.view);
                    this.pagination.total = data.data.length;

                    this.$emit('dataSoal', data.data);

                    this.showPages();

                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        checkView(index) {
            return index > this.pagination.to || index < this.pagination.from ? false : true;
        },
        changeView() {
            this.changePage(1);
            this.showPages();
        },
        changePage(page) {
            if (page >= 1 && page <= this.pagination.lastPage) {

                this.showPages();

                const total = this.items.length;
                const lastPage = Math.ceil(total / this.view) || 1;
                const from = (page - 1) * this.view + 1;
                let to = page * this.view;

                if (page === lastPage) {
                    to = total;
                }

                this.pagination.total = total;
                this.pagination.lastPage = lastPage;
                this.pagination.perPage = this.view;
                this.pagination.currentPage = page;
                this.pagination.from = from;
                this.pagination.to = to;

            }
        },
        showPages() {
            const pages = [];
            let from = this.pagination.currentPage - Math.ceil(this.pagination.offset / 2);

            if (from < 1) {
                from = 1;
            }

            let to = from + this.pagination.offset - 1;

            if (to > this.pagination.lastPage) {
                to = this.pagination.lastPage;
            }

            while (from <= to) {
                pages.push(from);
                from++;
            }

            this.pagination.pages = pages;
        },
        clickPage(page) {
            this.changePage(page);
            this.showPages();
        },
        listViewBinding() {
            const list = [];
            for (let index = 0; index < this.listView.length; index++) {
                if (this.listView[index] < this.items.length) {
                    list.push(this.listView[index]);
                }
            }

            const itemsLength = parseInt(JSON.stringify(this.items.length));

            list.push(itemsLength);

            return list;
        },
        search(value) {
            if (value.length >= 1) {
                const options = {
                    shouldSort: true,
                    keys: ['nama_soal', 'nama_jurusan', 'nama_tingkat'],
                    threshold: 0
                };
                const fuse = new Fuse(this.data, options);
                this.items = fuse.search(value).map(elem => elem.item);
            } else {
                this.items = this.data;
            }
        },
        formCreateSoalOpen(){
            this.$emit('isFormCreateSoalTrue', true);
        },
        formEditSoalOpen(id){
            const data = {
                id: id,
                status: true
            };
            this.$emit('isFormEditSoalTrue', data);
        },
        deleteDialogSoalOpen(id){
            const data = {
                id: id,
                status: true
            };
            this.$emit('isDeleteDialogSoalTrue', data);
        }
    }
}
</script>