<template>
    <div class="z-50 bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
        <div class="bg-white dark:bg-gray-900 px-16 py-14 rounded-md">
            <h1 class="text-xl mb-4 font-bold dark:text-slate-200 text-slate-500">Edit Jurusan</h1>
            <div class="grid mb-2">
                <div>
                    <label class="block mb-2 text-sm font-medium dark:text-slate-300 text-slate-900">Nama Jurusan</label>
                    <input v-model="dataUpdate.nama_jurusan" type="text"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           :class="{ 'border-2 border-red-400 dark:border-2 dark:border-red-500': updateError.namaJurusanErrorMessage }">
                    <span class="text-red-500 text-sm font-bold">{{ updateError.namaJurusanErrorMessage }}</span>
                </div>
            </div>
            <div class="flex justify-end gap-2">
                <button @click="updateJurusan"
                        class="px-5 py-2.5 bg-blue-200 dark:bg-blue-400 hover:bg-blue-300 dark:hover:bg-blue-500 text-sm rounded-lg inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Perbarui
                </button>
                <button @click="formToEditJurusanClose"
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
    name: "FormEditJurusan",
    props: {
        token: {
            type: String
        },
        dataUpdate: {
            type: Object
        }
    },
    emits: [
        "isFormToEditJurusanFalse"
    ],
    data(){
        return {
            updateError: {
                namaJurusanErrorMessage: ''
            }
        }
    },
    methods: {
        updateJurusan(){
            axios.put("/api/admin/jurusan/update", {
                id: this.dataUpdate.id,
                nama_jurusan: this.dataUpdate.nama_jurusan,
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
                this.resetForm();
                const errorMessage = response.data.error_message;
                if (this.isObject(errorMessage)){
                    Object.keys(errorMessage).forEach((key) => {
                        if (key === "nama_jurusan"){
                            this.updateError.namaJurusanErrorMessage = errorMessage[key][0];
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
        formToEditJurusanClose(){
            this.resetForm();
            this.$emit('isFormToEditJurusanFalse', false);
        },
        resetForm(){
            this.updateError.namaJurusanErrorMessage = '';
        }
    }
}
</script>
