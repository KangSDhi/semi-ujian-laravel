<template>
    <div class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
        <div class="bg-white px-16 py-14 rounded-md text-center">
            <h1 class="text-xl mb-2 font-bold text-slate-500">Apakah Anda Ingin Menghapus?</h1>
            <h2 class="text-md mb-2 font-semibold text-slate-400">{{ dataDelete.nama_soal }}</h2>
            <div class="grid grid-cols-2 gap-1">
                <button @click="deleteSoal"
                    class="bg-red-500 px-4 py-2 rounded-md text-md font-semibold text-white">Hapus</button>
                <button @click="deleteDialogSoalClose"
                    class="bg-gray-500 px-4 py-2 rounded-md text-md font-semibold text-white ml-1">Batal</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "DeleteDialogSoal",
    props: {
        token: {
            type: String
        },
        dataDelete: {
            type: Object
        }
    },
    methods: {
        deleteSoal() {
            this.loadingDialogOpen();
            axios.delete("/api/admin/soal/delete/" + this.dataDelete.id, {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then((data) => {
                    this.loadingDialogClose();
                    this.$router.go();
                })
                .catch((error) => {
                    this.loadingDialogClose();
                    console.error(error);
                });
        },
        deleteDialogSoalClose(){
            this.$emit('isDeleteDialogSoalFalse', false);
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