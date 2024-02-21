<template>
    <div class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
        <div class="bg-white dark:bg-gray-900 px-16 py-14 rounded-md">
            <h1 class="text-xl mb-4 font-bold dark:text-slate-200 text-slate-500">Tambah Soal</h1>
            <div class="grid md:grid-cols-2 gap-1">
                <div>
                    <label for="input-nama-soal-create" class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Nama Soal</label>
                    <input id="input-nama-soal-create" v-model="dataCreate.nama_soal" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': createError.namaSoalErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ createError.namaSoalErrorMessage }}</span>
                </div>
                <div>
                    <label for="input-link-soal-create" class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Link</label>
                    <input id="input-link-soal-create" v-model="dataCreate.link" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': createError.linkErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ createError.linkErrorMessage }}</span>
                </div>
                <div>
                    <label for="select-jurusan-create" class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Jurusan</label>
                    <select id="select-jurusan-create" v-model="dataCreate.nama_jurusan"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': createError.namaJurusanErrorMessage }">
                        <option :value="null" :selected="true">Semua</option>
                        <template v-for="(item, index) in dataJurusan" :key="index">
                            <option :value="item.nama_jurusan">{{
                                item.nama_jurusan }}</option>
                        </template>
                    </select>
                    <span class="text-red-500 text-sm font-bold">{{ createError.namaJurusanErrorMessage }}</span>
                </div>
                <div>
                    <label for="select-tingkat-create" class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Tingkat</label>
                    <select id="select-tingkat-create" v-model="dataCreate.nama_tingkat"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': createError.namaTingkatErrorMessage }">
                        <template v-for="(item, index) in dataTingkat" :key="index">
                            <option :value="item.nama_tingkat">{{
                                item.nama_tingkat }}</option>
                        </template>
                    </select>
                    <span class="text-red-500 text-sm font-bold">{{ createError.namaTingkatErrorMessage }}</span>
                </div>
                <div>
                    <label for="input-waktu-mulai-create" class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Waktu Mulai</label>
                    <input id="input-waktu-mulai-create"  v-model="dataCreate.waktu_mulai" type="datetime-local"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': createError.waktuMulaiErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ createError.waktuMulaiErrorMessage }}</span>
                </div>
                <div>
                    <label for="input-waktu-selesai-create" class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Waktu Selesai</label>
                    <input id="input-waktu-selesai-create"  v-model="dataCreate.waktu_selesai" type="datetime-local"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': createError.waktuSelesaiErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ createError.waktuSelesaiErrorMessage }}</span>
                </div>
            </div>
            <div class="flex mt-3 justify-end gap-2">
                <button @click="createSoal"
                    class="px-5 py-2.5 bg-blue-200 dark:bg-blue-400 hover:bg-blue-300 dark:hover:bg-blue-500 text-sm rounded-lg inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                    </svg>
                    Simpan
                </button>
                <button @click="formCreateSoalClose"
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
    name: "FormCreateSoal",
    props: {
        token: {
            type: String
        },
        dataJurusan: {
            type: Array
        },
        dataTingkat: {
            type: Array
        },
    },
    data() {
        return {
            dataCreate: {
                nama_soal: '',
                link: '',
                nama_jurusan: '',
                nama_tingkat: '',
                waktu_mulai: '',
                waktu_selesai: '',
            },
            createError: {
                namaSoalErrorMessage: '',
                linkErrorMessage: '',
                namaJurusanErrorMessage: '',
                namaTingkatErrorMessage: '',
                waktuMulaiErrorMessage: '',
                waktuSelesaiErrorMessage: '',
            },
        }
    },
    methods: {
        createSoal() {
            this.loadingDialogOpen();
            axios.post("/api/admin/soal/create", {
                nama_soal: this.dataCreate.nama_soal,
                link: this.dataCreate.link,
                nama_jurusan: this.dataCreate.nama_jurusan,
                nama_tingkat: this.dataCreate.nama_tingkat,
                waktu_mulai: this.dataCreate.waktu_mulai,
                waktu_selesai: this.dataCreate.waktu_selesai
            }, {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
                    this.loadingDialogClose();
                    this.$router.go();
                })
                .catch(({ response }) => {
                    this.loadingDialogClose();
                    this.createError.namaSoalErrorMessage = '';
                    this.createError.linkErrorMessage = '';
                    this.createError.namaJurusanErrorMessage = '';
                    this.createError.namaTingkatErrorMessage = '';
                    this.createError.waktuMulaiErrorMessage = '';
                    this.createError.waktuSelesaiErrorMessage = '';

                    const errorMessages = response.data.error_message;
                    if (this.isObject(errorMessages)) {
                        Object.keys(errorMessages).forEach((key) => {
                            if (key == "nama_soal") {
                                this.createError.namaSoalErrorMessage = errorMessages[key][0];
                            }
                            if (key == "link") {
                                this.createError.linkErrorMessage = errorMessages[key][0];
                            }
                            if (key == "nama_jurusan") {
                                this.createError.namaJurusanErrorMessage = errorMessages[key][0];
                            }
                            if (key == "nama_tingkat") {
                                this.createError.namaTingkatErrorMessage = errorMessages[key][0];
                            }
                            if (key == "waktu_mulai") {
                                this.createError.waktuMulaiErrorMessage = errorMessages[key][0];
                            }
                            if (key == "waktu_selesai") {
                                this.createError.waktuSelesaiErrorMessage = errorMessages[key][0];
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
        formCreateSoalClose() {
            this.$emit('isFormCreateSoalFalse', false);
        },
        loadingDialogOpen(){
            this.$emit('isLoadingTrue', true);
        },
        loadingDialogClose(){
            this.$emit('isLoadingFalse', false);
        },
    }
}
</script>