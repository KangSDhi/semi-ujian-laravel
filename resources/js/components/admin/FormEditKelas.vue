<template>
    <div class="z-50 bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
        <div class="bg-white dark:bg-gray-900 px-16 py-14 rounded-md">
            <h1 class="text-xl mb-4 font-bold dark:text-slate-200 text-slate-500">Edit Kelas</h1>
            <div class="grid grid-cols-2 gap-2 mb-2">
                <div>
                    <label class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">
                        Nama Kelas
                    </label>
                    <input v-model="dataUpdate.nama_kelas" type="text"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': updateError.namaKelasErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ updateError.namaKelasErrorMessage }}</span>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">
                        Tingkat
                    </label>
                    <select v-model="dataUpdate.tingkat_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': updateError.namaTingkatErrorMessage }">
                        <template v-for="(item, index) in dataTingkat" :key="index">
                            <option :value="item.id">{{ item.nama_tingkat }}</option>
                        </template>
                    </select>
                    <span class="text-red-500 text-sm font-bold">{{ updateError.namaTingkatErrorMessage }}</span>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">
                        Jurusan
                    </label>
                    <select v-model="dataUpdate.jurusan_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': updateError.namaJurusanErrorMessage }">
                        <template v-for="(item, index) in dataJurusan" :key="index">
                            <option :value="item.id">{{ item.nama_jurusan }}</option>
                        </template>
                    </select>
                    <span class="text-red-500 text-sm font-bold">{{ updateError.namaJurusanErrorMessage }}</span>
                </div>
            </div>
            <div class="flex justify-end gap-2">
                <button @click="updateKelas"
                        class="px-5 py-2.5 bg-blue-200 dark:bg-blue-400 hover:bg-blue-300 dark:hover:bg-blue-500 text-sm rounded-lg inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                    </svg>
                    Perbarui
                </button>
                <button @click="formToEditKelasClose"
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
    name: "FormEditKelas",
    props: {
        token: {
            type: String
        },
        dataTingkat: {
            type: Array
        },
        dataJurusan: {
            type: Array
        },
        dataUpdate: {
            type: Object
        }
    },
    emits: [
        "isFormToEditKelasFalse"
    ],
    data(){
        return {
            updateError: {
                namaKelasErrorMessage: '',
                namaTingkatErrorMessage: '',
                namaJurusanErrorMessage: ''
            }
        }
    },
    methods: {
        updateKelas(){
            axios.put("/api/admin/kelas/update", {
                id: this.dataUpdate.id,
                nama_kelas: this.dataUpdate.nama_kelas,
                tingkat_id: this.dataUpdate.tingkat_id,
                jurusan_id: this.dataUpdate.jurusan_id,
                _method: "put"
            }, {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            }).then(({ data }) => {
                this.$router.go();
                console.log(data);
            }).catch(({ response }) => {
                console.error(response);
                const errorMessage = response.data.error_message;
                if (this.isObject(errorMessage)){
                    Object.keys(errorMessage).forEach((key) => {
                        if (key === "nama_kelas"){
                            this.updateError.namaKelasErrorMessage = errorMessage[key][0];
                        }

                        if (key === "tingkat_id"){
                            this.updateError.namaTingkatErrorMessage = errorMessage[key][0];
                        }

                        if (key === "jurusan_id"){
                            this.updateError.namaJurusanErrorMessage = errorMessage[key][0];
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
        formToEditKelasClose(){
            this.$emit('isFormToEditKelasFalse', false);
        }
    }
}
</script>
