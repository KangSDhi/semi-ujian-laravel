<template>
    <div class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
        <div class="bg-white dark:bg-gray-900 px-16 py-14 rounded-md">
            <h1 class="text-xl mb-4 font-bold dark:text-slate-200 text-slate-500">Buat Siswa</h1>
            <div class="grid md:grid-cols-2 gap-1">
                <div>
                    <label class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Nama
                        Siswa</label>
                    <input v-model="dataCreate.nama_siswa" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': createError.namaSiswaErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ createError.namaSiswaErrorMessage }}</span>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">NISN</label>
                    <input v-model="dataCreate.nisn" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': createError.nisnErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ createError.nisnErrorMessage }}</span>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Password</label>
                    <input v-model="dataCreate.password" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': createError.passwordErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ createError.passwordErrorMessage }}</span>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Password
                        Konfirmasi</label>
                    <input v-model="dataCreate.password_konfirmasi" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': createError.passwordKonfirmasiErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ createError.passwordKonfirmasiErrorMessage
                    }}</span>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Kelas</label>
                    <select v-model="dataCreate.nama_kelas"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': createError.kelasErrorMessage }">
                        <template v-for="(item, index) in dataKelas" :key="index">
                            <option :value="item.nama_kelas">{{
                                item.nama_kelas }}</option>
                        </template>
                    </select>
                    <span class="text-red-500 text-sm font-bold">{{ createError.kelasErrorMessage }}</span>
                </div>
            </div>
            <div class="flex justify-end gap-2">
                <button @click="createSiswa"
                    class="px-5 py-2.5 bg-blue-200 dark:bg-blue-400 hover:bg-blue-300 dark:hover:bg-blue-500 text-sm rounded-lg inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                    </svg>
                    Simpan
                </button>
                <button @click="formCreateSiswaClose"
                    class="px-5 py-2.5 bg-gray-200 dark:bg-gray-400 hover:bg-gray-300 dark:hover:bg-gray-500 text-sm rounded-lg inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    Batal
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "FormCreateSiswa",
    props: {
        token: {
            type: String
        },
        dataKelas: {
            type: Array
        },
    },
    data() {
        return {
            dataCreate: {
                nama_siswa: '',
                nisn: '',
                password: '',
                password_konfirmasi: '',
                nama_kelas: '',
            },
            createError: {
                namaSiswaErrorMessage: '',
                nisnErrorMessage: '',
                passwordErrorMessage: '',
                passwordKonfirmasiErrorMessage: '',
                kelasErrorMessage: ''
            },
        }
    },
    methods: {
        createSiswa() {
            axios.post("/api/admin/siswa/create", {
                nama_siswa: this.dataCreate.nama_siswa,
                nisn: this.dataCreate.nisn,
                password: this.dataCreate.password,
                password_konfirmasi: this.dataCreate.password_konfirmasi,
                nama_kelas: this.dataCreate.nama_kelas
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
                    this.createError.nisnErrorMessage = '';
                    this.createError.namaSiswaErrorMessage = '';
                    this.createError.kelasErrorMessage = '';
                    this.createError.passwordErrorMessage = '';
                    this.createError.passwordKonfirmasiErrorMessage = '';
                    console.error(response);
                    const errorMessages = response.data.error_message;
                    if (this.isObject(errorMessages)) {
                        Object.keys(errorMessages).forEach((key) => {
                            if (key == "nama_siswa") {
                                this.createError.namaSiswaErrorMessage = errorMessages[key][0];
                            }
                            if (key == "nisn") {
                                this.createError.nisnErrorMessage = errorMessages[key][0];
                            }
                            if (key == "password") {
                                this.createError.passwordErrorMessage = errorMessages[key][0];
                            }
                            if (key == "password_konfirmasi") {
                                this.createError.passwordKonfirmasiErrorMessage = errorMessages[key][0];
                            }
                            if (key == "nama_kelas") {
                                this.createError.kelasErrorMessage = errorMessages[key][0];
                            }
                        })
                    }
                });
        },
        isObject(value) {
            return (
                typeof value === 'object' && value !== null && !Array.isArray(value)
            );
        },
        formCreateSiswaClose(){
            this.$emit('isFormCreateSiswaFalse', false);
        }
    }
}
</script>