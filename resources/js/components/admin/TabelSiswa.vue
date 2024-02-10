<template>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="justify-self-center sm:justify-self-start">
            <select v-model="view" @change="changeView()"
                class="block w-60 p-2 mb-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <template v-for="(item, index) in listViewBinding()">
                    <option :value="item">{{ item }}</option>
                </template>
            </select>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3">
            <button @click="formCreateSiswaOpen"
                class="px-5 py-2 h-10 justify-self-center bg-blue-200 dark:bg-blue-400 hover:bg-blue-300 dark:hover:bg-blue-500 text-sm me-2 rounded-lg inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Siswa
            </button>
            <button @click="formUploadSiswaOpen"
                class="px-5 py-2 h-10 justify-self-center bg-yellow-200 dark:bg-yellow-400 hover:bg-yellow-300 dark:hover:bg-yellow-500 text-sm me-2 rounded-lg inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                </svg>
                Upload Siswa
            </button>
            <ButtonExportDataSiswa :data-siswa="data"/>
        </div>
        <div class="justify-self-center mb-2 sm:justify-self-end">
            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input v-model="searchInput" type="search" id="default-search"
                    class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Cari Nama, NISN, Kelas ....">

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
                        <div class="flex items-center gap-2">
                            <span>NISN</span>
                            <div class="flex flex-col">
                                <svg @click="sort('nisn', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" width="12px" height="12px"
                                    class="cursor-pointer">
                                    <path d="M5 15l7-7 7 7"></path>
                                </svg>
                                <svg @click="sort('nisn', 'desc')" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor"
                                    width="12px" height="12px" class="cursor-pointer">
                                    <path d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center gap-2">
                            <span>Nama Siswa</span>
                            <div class="flex flex-col">
                                <svg @click="sort('nama_siswa', 'asc')" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor"
                                    width="12px" height="12px" class="cursor-pointer">
                                    <path d="M5 15l7-7 7 7"></path>
                                </svg>
                                <svg @click="sort('nama_siswa', 'desc')" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor"
                                    width="12px" height="12px" class="cursor-pointer">
                                    <path d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center gap-2">
                            <span>Nama Kelas</span>
                            <div class="flex flex-col">
                                <svg @click="sort('nama_kelas', 'asc')" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor"
                                    width="12px" height="12px" class="cursor-pointer">
                                    <path d="M5 15l7-7 7 7"></path>
                                </svg>
                                <svg @click="sort('nama_kelas', 'desc')" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor"
                                    width="12px" height="12px" class="cursor-pointer">
                                    <path d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Password
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="">Aksi</span>
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
                            {{ item.nisn }}
                        </td>
                        <td class="px-6 py-4">
                            {{ item.nama_siswa }}
                        </td>
                        <td class="px-6 py-4">
                            {{ item.nama_kelas }}
                        </td>
                        <td class="px-6 py-4">
                            {{ item.password_dec }}
                        </td>
                        <td class="px-6 py-4 space-x-2 text-right">
                            <button @click="formEditSiswaOpen(item.id)"
                                class="bg-blue-200 px-2.5 py-1 text-gray-900 rounded-md inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                Edit
                            </button>
                            <button @click="deleteDialogSiswaOpen(item.id)"
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
                        :class="{ 'bg-black text-gray-50 dark:bg-white dark:text-gray-800': pagination.currentPage === item }">
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
                <button @click.prevent="clickPage(pagination.lastPage)"
                    class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-br-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    Akhir
                </button>
            </li>
        </ul>
    </nav>
</template>

<script>
import ButtonExportDataSiswa from "./ButtonExportDataSiswa.vue";
import axios from "axios";
import Fuse from "fuse.js";

export default {
    name: "TabelSiswa",
    emits: [
        "dataSiswa",
        "isFormCreateSiswaTrue",
        "isFormEditSiswaTrue",
        "isDeleteDialogSiswaTrue",
        "isFormUploadSiswaTrue",
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
                field: 'nama_kelas',
                rule: 'asc'
            },
        }
    },
    components: {
        ButtonExportDataSiswa,
    },
    mounted(){
        this.getDataSiswa();
    },
    watch: {
        searchInput: function(newVal, oldVal){
            this.search(newVal);
        }
    },
    methods: {
        getDataSiswa(){
            axios.get("/api/admin/siswa", {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
                    this.items = this.data = data.data;
                    this.pagination.lastPage = Math.ceil(data.data.length / this.view);
                    this.pagination.total = data.data.length;

                    this.$emit('dataSiswa', data.data);

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
                    keys: ['nama_siswa', 'nisn', 'nama_kelas'],
                    threshold: 0
                };
                const fuse = new Fuse(this.data, options);
                this.items = fuse.search(value).map(elem => elem.item);
            } else {
                this.items = this.data;
            }
        },
        sort(field, rule) {
            this.items = this.items.sort(this.compareOnKey(field, rule));
            this.sorted.field = field;
            this.sorted.rule = rule;
        },
        compareOnKey(key, rule) {
            return function (a, b) {
                if (key === "nisn" || key == "nama_siswa" || key == "nama_kelas") {
                    let comparison = 0;
                    const fieldA = a[key].toUpperCase();
                    const fieldB = b[key].toUpperCase();
                    if (rule === 'asc') {
                        if (fieldA > fieldB) {
                            comparison = 1;
                        } else if (fieldA < fieldB) {
                            comparison = -1;
                        }
                    } else {
                        if (fieldA < fieldB) {
                            comparison = 1;
                        } else if (fieldA > fieldB) {
                            comparison = -1
                        }
                    }
                    return comparison;
                }
            }
        },
        formCreateSiswaOpen(){
            this.$emit('isFormCreateSiswaTrue', true);
        },
        formEditSiswaOpen(id){
            const data = {
                id: id,
                status: true
            };
            this.$emit('isFormEditSiswaTrue', data);
        },
        deleteDialogSiswaOpen(id){
            const data = {
                id: id,
                status: true
            };
            this.$emit('isDeleteDialogSiswaTrue', data);
        },
        formUploadSiswaOpen(){
            this.$emit('isFormUploadSiswaTrue', true);
        }

    }
}
</script>