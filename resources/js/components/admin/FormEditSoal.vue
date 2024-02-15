<template>
    <div class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
        <div class="bg-white dark:bg-gray-900 px-16 py-14 rounded-md">
            <h1 class="text-xl mb-4 font-bold dark:text-slate-200 text-slate-500">Edit Soal</h1>
            <div class="grid md:grid-cols-2 gap-1">
                <div>
                    <label for="input-nama-soal-update" class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Nama Soal</label>
                    <input id="input-nama-soal-update" v-model="dataUpdate.nama_soal" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': updateError.namaSoalErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ updateError.namaSoalErrorMessage }}</span>
                </div>
                <div>
                    <label for="input-link-update" class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Link</label>
                    <input id="input-link-update" v-model="dataUpdate.link" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': updateError.linkErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ updateError.linkErrorMessage }}</span>
                </div>
                <div>
                    <label for="select-jurusan-update" class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Jurusan</label>
                    <select id="select-jurusan-update" v-model="dataUpdate.nama_jurusan"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': updateError.namaJurusanErrorMessage }">
                        <option :value="null" :selected="dataUpdate.nama_jurusan === null">Semua</option>
                        <template v-for="(item, index) in dataJurusan" :key="index">
                            <option :value="item.nama_jurusan" :selected="item.nama_jurusan === dataUpdate.nama_jurusan">{{
                                item.nama_jurusan }}</option>
                        </template>
                    </select>
                    <span class="text-red-500 text-sm font-bold">{{ updateError.namaJurusanErrorMessage }}</span>
                </div>
                <div>
                    <label for="select-tingkat-update" class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Tingkat</label>
                    <select id="select-tingkat-update" v-model="dataUpdate.nama_tingkat"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': updateError.namaTingkatErrorMessage }">
                        <template v-for="(item, index) in dataTingkat" :key="index">
                            <option :value="item.nama_tingkat" :selected="item.nama_tingkat === dataUpdate.nama_tingkat">{{
                                item.nama_tingkat }}</option>
                        </template>
                    </select>
                    <span class="text-red-500 text-sm font-bold">{{ updateError.namaTingkatErrorMessage }}</span>
                </div>
                <div>
                    <label for="input-waktu-mulai-update" class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Waktu Mulai</label>
                    <input id="input-waktu-mulai-update" v-model="dataUpdate.waktu_mulai" type="datetime-local"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': updateError.waktuMulaiErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ updateError.waktuMulaiErrorMessage }}</span>
                </div>
                <div>
                    <label for="input-waktu-selesai-update" class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Waktu Selesai</label>
                    <input id="input-waktu-selesai-update" v-model="dataUpdate.waktu_selesai" type="datetime-local"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': updateError.waktuSelesaiErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ updateError.waktuSelesaiErrorMessage }}</span>
                </div>
            </div>
            <div class="flex mt-3 justify-end gap-2">
                <button @click="updateSoal"
                    class="px-5 py-2.5 bg-blue-200 dark:bg-blue-400 hover:bg-blue-300 dark:hover:bg-blue-500 text-sm rounded-lg inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Perbarui
                </button>
                <button @click="formEditSoalClose"
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
    name: "FormUpdateSoal",
    props: {
        token: {
            type: String
        },
        dataUpdate: {
            type: Object
        },
        dataJurusan: {
            type: Array
        },
        dataTingkat: {
            type: Array
        },
    },
    data(){
        return {
            updateError: {
                namaSoalErrorMessage: '',
                namaJurusanErrorMessage: '',
                namaTingkatErrorMessage: '',
                linkErrorMessage: '',
                waktuMulaiErrorMessage: '',
                waktuSelesaiErrorMessage: ''
            }
        }
    },
    methods: {
        updateSoal() {
            this.loadingDialogOpen();
            axios.put("/api/admin/soal/update", {
                id: this.dataUpdate.id,
                nama_soal: this.dataUpdate.nama_soal,
                link: this.dataUpdate.link,
                nama_jurusan: this.dataUpdate.nama_jurusan,
                nama_tingkat: this.dataUpdate.nama_tingkat,
                waktu_mulai: this.dataUpdate.waktu_mulai,
                waktu_selesai: this.dataUpdate.waktu_selesai,
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
                    this.updateError.namaSoalErrorMessage = '';
                    this.updateError.linkErrorMessage = '';
                    this.updateError.namaJurusanErrorMessage = '';
                    this.updateError.namaTingkatErrorMessage = '';
                    this.updateError.waktuMulaiErrorMessage = '';
                    this.updateError.waktuSelesaiErrorMessage = '';

                    const errorMessages = response.data.error_message;
                    if (this.isObject(errorMessages)) {
                        Object.keys(errorMessages).forEach((key) => {
                            if (key == "nama_soal") {
                                this.updateError.namaSoalErrorMessage = errorMessages[key][0];
                            }
                            if (key == "link") {
                                this.updateError.linkErrorMessage = errorMessages[key][0];
                            }
                            if (key == "nama_jurusan") {
                                this.updateError.namaJurusanErrorMessage = errorMessages[key][0];
                            }
                            if (key == "nama_tingkat") {
                                this.updateError.namaTingkatErrorMessage = errorMessages[key][0];
                            }
                            if (key == "waktu_mulai") {
                                this.updateError.waktuMulaiErrorMessage = errorMessages[key][0];
                            }
                            if (key == "waktu_selesai") {
                                this.updateError.waktuSelesaiErrorMessage = errorMessages[key][0];
                            }
                        })
                    }
                })
        },
        isObject(value) {
            return (
                typeof value === 'object' && value !== null && !Array.isArray(value)
            );
        },
        formEditSoalClose(){
            this.$emit('isFormEditSoalFalse', false);
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