<template>
    <div class="z-50 bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
        <div class="bg-white px-16 py-14 rounded-md text-center">
            <h1 class="text-xl mb-2 font-bold text-slate-500">Apakah Anda Ingin Menghapus Jurusan?</h1>
            <h2 class="text-md mb-2 font-semibold text-slate-400">{{ dataDelete.nama_jurusan }}</h2>
            <div class="grid grid-cols-2 gap-1">
                <button @click="deleteJurusan"
                        class="bg-red-500 px-4 py-2 rounded-md text-md font-semibold text-white">Hapus</button>
                <button @click="dialogDeleteJurusanClose"
                        class="bg-gray-500 px-4 py-2 rounded-md text-md font-semibold text-white ml-1">Batal</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "DeleteDialogJurusan",
    props: {
        token: {
            type: String
        },
        dataDelete: {
            type: Object
        }
    },
    emits: [
        "isDialogToDeleteJurusanFalse"
    ],
    methods: {
        deleteJurusan(){
            axios.delete("/api/admin/jurusan/delete/" + this.dataDelete.id, {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            }).then(({ data }) => {
                console.log(data);
                this.$router.go();
            }).catch(({ response }) => {
                console.log(response);
            })
        },
        dialogDeleteJurusanClose(){
            this.$emit('isDialogToDeleteJurusanFalse', false);
        }
    }
}
</script>
