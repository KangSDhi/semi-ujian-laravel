<template>
    <BaseLayout>
        <template #content>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="justify-self-center sm:justify-self-start">
                    <select v-model="view" @change="changeView()"
                        class="block w-60 p-2 mb-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <template v-for="(item, index) in listViewBinding()">
                            <option :value="item">{{ item }}</option>
                        </template>
                    </select>
                </div>
                <div class="justify-self-center space-x-2">
                    <button
                        class="px-5 py-2.5 bg-blue-400 hover:bg-blue-500 text-sm me-2 rounded-lg inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Siswa
                    </button>
                    <button @click="isFormUploadSiswa = true"
                        class="px-5 py-2.5 bg-yellow-400 hover:bg-yellow-500 text-sm me-2 rounded-lg inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                        </svg>
                        Upload Siswa
                    </button>
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
                            placeholder="Cari Nama, NISN ....">

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
                                        <svg @click="sort('nisn', 'asc')" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24"
                                            stroke="currentColor" width="12px" height="12px" class="cursor-pointer">
                                            <path d="M5 15l7-7 7 7"></path>
                                        </svg>
                                        <svg @click="sort('nisn', 'desc')" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24"
                                            stroke="currentColor" width="12px" height="12px" class="cursor-pointer">
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
                                            stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24"
                                            stroke="currentColor" width="12px" height="12px" class="cursor-pointer">
                                            <path d="M5 15l7-7 7 7"></path>
                                        </svg>
                                        <svg @click="sort('nama_siswa', 'desc')" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24"
                                            stroke="currentColor" width="12px" height="12px" class="cursor-pointer">
                                            <path d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center gap-2">
                                    <span>Jurusan</span>
                                    <div class="flex flex-col">
                                        <svg @click="sort('nama_jurusan', 'asc')" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24"
                                            stroke="currentColor" width="12px" height="12px" class="cursor-pointer">
                                            <path d="M5 15l7-7 7 7"></path>
                                        </svg>
                                        <svg @click="sort('nama_jurusan', 'desc')" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24"
                                            stroke="currentColor" width="12px" height="12px" class="cursor-pointer">
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
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th class="text-xl" colspan="6">Data Kosong</th>
                            </tr>
                        </template>
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
                                <td class="px-6 py-4 space-x-4 text-right">
                                    <button @click="showUpdateDialog(item.id)"
                                        class="bg-blue-200 px-2.5 py-1 text-gray-900 rounded-md">Edit</button>
                                    <button @click="showDeleteDialog(item.id)" class="text-red-500 mt-2">Hapus</button>
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
                        <button @click.prevent="clickPage(pagination.lastPage)"
                            class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-br-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            Akhir
                        </button>
                    </li>
                </ul>
            </nav>
            <div v-show="isFormUploadSiswa"
                class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
                <div class="bg-white px-16 py-14 rounded-md text-center">
                    <h1 class="text-xl mb-4 font-bold text-slate-500">Upload Siswa</h1>
                    <div class="grid grid-cols-1 justify-items-center gap-1">
                        <input @change="fileUploadSiswa"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            type="file"
                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        <div class="flex w-full gap-2">
                            <button @click="uploadSiswa"
                                class="px-5 mt-5 py-2.5 w-1/2 bg-yellow-400 hover:bg-yellow-500 text-xs me-2 rounded-lg inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                                </svg>
                                Upload Siswa
                            </button>
                            <button @click="isFormUploadSiswa = false"
                                class="px-5 text-xs mt-5 py-2.5 w-1/2 bg-gray-100 hover:bg-gray-200 me-2 rounded-lg inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-show="isLoading"
                class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
                <div class="bg-white px-16 py-14 rounded-md text-center">
                    <h1 class="text-xl mb-4 font-bold text-slate-500">Sabar Nggih....</h1>
                    <div class="flex justify-center">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div v-show="isDeleteDialog"
                class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
                <div class="bg-white px-16 py-14 rounded-md text-center">
                    <h1 class="text-xl mb-2 font-bold text-slate-500">Apakah Anda Ingin Menghapus?</h1>
                    <h2 class="text-md mb-2 font-semibold text-slate-400">{{ dataDelete.nama_siswa }}</h2>
                    <div class="grid grid-cols-2 gap-1">
                        <button @click="deleteSiswa"
                            class="bg-red-500 px-4 py-2 rounded-md text-md font-semibold text-white">Hapus</button>
                        <button @click="isDeleteDialog = false"
                            class="bg-gray-500 px-4 py-2 rounded-md text-md font-semibold text-white ml-1">Batal</button>
                    </div>
                </div>
            </div>
            <div v-show="isUpdateDialog"
                class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
                <div class="bg-white px-16 py-14 rounded-md">
                    <h1 class="text-xl mb-4 font-bold text-slate-500">Edit</h1>
                    <div class="grid md:grid-cols-2 gap-1">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-white dark:text-gray-900">Nama Siswa</label>
                            <input v-model="dataUpdate.nama_siswa" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                :class="{ 'dark:border-2 dark:border-red-500': updateError.namaSiswaErrorMessage }">
                            <span class="text-red-500 text-sm font-bold">{{ updateError.namaSiswaErrorMessage }}</span>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-white dark:text-gray-900">NISN</label>
                            <input v-model="dataUpdate.nisn" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                :class="{ 'dark:border-2 dark:border-red-500': updateError.nisnErrorMessage }">
                            <span class="text-red-500 text-sm font-bold">{{ updateError.nisnErrorMessage }}</span>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-white dark:text-gray-900">Password</label>
                            <input v-model="dataUpdate.password_dec" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                :class="{ 'dark:border-2 dark:border-red-500': updateError.passwordErrorMessage }">
                            <span class="text-red-500 text-sm font-bold">{{ updateError.passwordErrorMessage }}</span>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-white dark:text-gray-900">Password
                                Konfirmasi</label>
                            <input v-model="dataUpdate.password_konfirmasi" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                :class="{ 'dark:border-2 dark:border-red-500': updateError.passwordKonfirmasiErrorMessage }">
                            <span class="text-red-500 text-sm font-bold">{{ updateError.passwordKonfirmasiErrorMessage
                            }}</span>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-white dark:text-gray-900">Jurusan</label>
                            <select v-model="dataUpdate.nama_jurusan"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                :class="{ 'dark:border-2 dark:border-red-500': updateError.jurusanErrorMessage }">
                                <template v-for="(item, index) in dataJurusan" :key="index">
                                    <option :value="item.nama" :selected="item.nama === dataUpdate.nama_jurusan">{{
                                        item.nama }}</option>
                                </template>
                            </select>
                            <span class="text-red-500 text-sm font-bold">{{ updateError.jurusanErrorMessage }}</span>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button @click="updateSiswa"
                            class="px-5 py-2.5 bg-blue-400 hover:bg-blue-500 text-sm rounded-lg inline-flex items-center">
                            Simpan
                        </button>
                        <button @click="isUpdateDialog = false"
                            class="px-5 py-2.5 bg-gray-400 hover:bg-gray-500 text-sm rounded-lg inline-flex items-center">
                            Batal
                        </button>
                    </div>
                </div>
            </div>

            <div v-show="uploadError.length != 0"
                class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
                <div class="bg-white px-16 py-14 rounded-md">
                    <h1 class="text-2xl mb-4 font-bold text-red-500">Error!</h1>
                    <div class="flex flex-col">
                        <template v-for="(item, index) in uploadError">
                            <span class="text-red-500 text-xl font-semibold">{{ '* '+item }}</span>
                        </template>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button @click="uploadError = []" class="bg-gray-400 px-3 py-2 rounded-lg text-md">Tutup</button>
                    </div>
                </div>
            </div>
        </template>
    </BaseLayout>
</template>

<script>
import BaseLayout from './BaseLayout.vue';
import axios from 'axios';
import Fuse from "fuse.js";
import { read, utils, writeFile } from "xlsx";

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
            },
            isLoading: false,
            isFormUploadSiswa: false,
            uploadError: [],
            dataUploadSiswa: [],
            dataDelete: [],
            isDeleteDialog: false,
            dataUpdate: [],
            isUpdateDialog: false,
            updateError: {
                namaSiswaErrorMessage: '',
                nisnErrorMessage: '',
                passwordErrorMessage: '',
                passwordKonfirmasiErrorMessage: '',
                jurusanErrorMessage: ''
            },
            dataJurusan: [],
        }
    },
    components: {
        BaseLayout
    },
    mounted() {
        this.getJurusan();
        this.getSiswa();
    },
    watch: {
        searchInput: function (newVal, oldVal) {
            this.search(newVal);
        }
    },
    methods: {
        getJurusan() {
            axios.get("/api/admin/jurusan", {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
                    this.dataJurusan = data.data;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        getSiswa() {
            axios.get("/api/admin/siswa", {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
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
                    keys: ['nama_siswa', 'nisn'],
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
                if (key === "nisn" || key == "nama_siswa" || key == "nama_jurusan") {
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
        fileUploadSiswa(event) {
            const file = event.target.files[0];
            let datas = []
            this.readExcelFile(file)
                .then((data) => {
                    this.dataUploadSiswa = data;
                    console.log(this.dataUploadSiswa);
                })
                .catch((error) => {
                    console.log("Error reading Excel file:", error);
                });
        },
        readExcelFile(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsArrayBuffer(file);

                reader.onload = function (e) {
                    const binarystr = new Uint8Array(e.target.result);
                    const wb = read(binarystr, { type: 'array', raw: true, cellFormula: false });

                    const wsname = wb.SheetNames[0];
                    const data = utils.sheet_to_json(wb.Sheets[wsname]);

                    resolve(data);
                };

                reader.onerror = function (error) {
                    reject(error);
                }
            });
        },
        uploadSiswa() {
            this.isFormUploadSiswa = false;

            const fetchData = async () => {
                const promise = axios.post("/api/admin/siswa/create/batch", {
                    data: this.dataUploadSiswa
                }, {
                    headers: {
                        "Authorization": "Bearer " + this.token
                    }
                });

                this.isLoading = true;

                try {
                    const response = await promise;
                    this.isLoading = false
                    this.$router.go();
                    console.log(response.data);
                } catch ({ response }) {
                    this.isLoading = false;
                    console.log(this.uploadError.length);
                    // console.error(response.data.error_message);
                    const errorMessage = response.data.error_message;
                    Object.keys(errorMessage).forEach((key) => {
                        this.uploadError.push(errorMessage[key][0]);
                    });
                    console.log(this.uploadError.length);
                }
            };

            fetchData();
        },
        showDeleteDialog(id) {
            const data = JSON.parse(JSON.stringify(this.data));
            const index = data.findIndex((item) => item.id === id);
            this.dataDelete = data[index];
            this.isDeleteDialog = true;
        },
        deleteSiswa() {
            axios.get("/api/admin/siswa/delete/" + this.dataDelete.id, {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then((data) => {
                    console.log(data);
                    this.$router.go();
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        showUpdateDialog(id) {
            const data = JSON.parse(JSON.stringify(this.data));
            const index = data.findIndex((item) => item.id === id);
            this.dataUpdate = data[index];
            this.isUpdateDialog = true;
        },
        updateSiswa() {
            axios.put("/api/admin/siswa/update", {
                id: this.dataUpdate.id,
                nisn: this.dataUpdate.nisn,
                nama_siswa: this.dataUpdate.nama_siswa,
                nama_jurusan: this.dataUpdate.nama_jurusan,
                password: this.dataUpdate.password_dec,
                konfirmasi_password: this.dataUpdate.password_konfirmasi,
                _method: "put"
            }, {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
                    console.log(data);
                    this.$router.go();
                })
                .catch(({ response }) => {
                    this.updateError.nisnErrorMessage = '';
                    this.updateError.namaSiswaErrorMessage = '';
                    this.updateError.jurusanErrorMessage = '';
                    this.updateError.passwordErrorMessage = '';
                    this.updateError.passwordKonfirmasiErrorMessage = '';
                    const errorMessage = response.data.error_message;
                    if (this.isObject(errorMessage)) {
                        Object.keys(errorMessage).forEach((key) => {
                            if (key == "nisn") {
                                this.updateError.nisnErrorMessage = errorMessage[key][0];
                            }
                            if (key == "nama_siswa") {
                                this.updateError.namaSiswaErrorMessage = errorMessage[key][0];
                            }
                            if (key == "nama_jurusan") {
                                this.updateError.jurusanErrorMessage = errorMessage[key][0];
                            }
                            if (key == "password") {
                                this.updateError.passwordErrorMessage = errorMessage[key][0];
                            }
                            if (key == "konfirmasi_password") {
                                this.updateError.passwordKonfirmasiErrorMessage = errorMessage[key][0];
                            }
                        });
                    }

                });
        },
        isObject(value) {
            return (
                typeof value === 'object' && value !== null && !Array.isArray(value)
            );
        }
    }
}
</script>