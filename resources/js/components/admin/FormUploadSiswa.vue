<template>
    <div class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
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
                    <button @click="formUploadSiswaClose"
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
</template>

<script>
import axios from "axios";
import { read, utils } from "xlsx";

export default {
    name: "FormUploadSiswa",
    emits: [
        "isFormUploadSiswaFalse",
        "isLoadingTrue",
        "isLoadingFalse",
        "errorMessages",
    ],
    props: {
        token: {
            type: String
        }
    },
    data(){
        return {
            dataUploadSiswa: [],
            dataErrorMessages: [],
        }
    },
    components: {
    },
    methods: {
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
            this.formUploadSiswaClose();

            const postData = async () => {
                const promise = axios.post("/api/admin/siswa/create/batch", {
                    data: this.dataUploadSiswa
                }, {
                    headers: {
                        "Authorization": "Bearer " + this.token
                    }
                });

                // this.isLoading = true;
                this.loadingDialogOpen();

                try {
                    await promise;
                    // this.isLoading = false
                    this.loadingDialogClose();
                    this.$router.go();
                } catch ({ response }) {
                    // this.isLoading = false;
                    this.loadingDialogClose();
                    const errorMessage = response.data.error_message;
                    Object.keys(errorMessage).forEach((key) => {
                        this.dataErrorMessages.push(errorMessage[key][0]);
                    });
                    this.errorDialogOpen(this.dataErrorMessages);
                }
            };

            postData();
        },
        formUploadSiswaClose(){
            this.$emit('isFormUploadSiswaFalse', false);
        },
        loadingDialogOpen(){
            this.$emit('isLoadingTrue', true);
        },
        loadingDialogClose(){
            this.$emit('isLoadingFalse', false);
        },
        errorDialogOpen(errorMessages){
            this.$emit('errorMessages', errorMessages);
        }
    }
}
</script>