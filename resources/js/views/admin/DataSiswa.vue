<template>
    <BaseLayout>
        <template #content>
            <TabelSiswa
                @dataSiswa="setDataSiswa($event)"
                @isFormCreateSiswaTrue="formCreateSiswaToggle($event)"
                @isFormEditSiswaTrue="formEditSiswaOpen($event)"
                @isDeleteDialogSiswaTrue="deleteDialogSiswaOpen($event)"
                @isFormUploadSiswaTrue="formUploadSiswaToggle($event)"/>
            <FormCreateSiswa v-show="isFormCreateSiswa"
                :token="token"
                :data-kelas="dataKelas"
                @isFormCreateSiswaFalse="formCreateSiswaToggle($event)"
            />
            <FormEditSiswa v-show="isFormEditSiswa"
                :token="token"
                :data-update="dataUpdate"
                :data-kelas="dataKelas"
                @isFormEditSiswaFalse="formEditSiswaClose($event)"
            />
            <DeleteDialogSiswa v-show="isDeleteDialog"
                :token="token"
                :data-delete="dataDelete"
                @isDeleteDialogSiswaFalse="deleteDialogSiswaClose($event)"
            />
            <FormUploadSiswa v-show="isFormUploadSiswa"
                :token="token"
                @isFormUploadSiswaFalse="formUploadSiswaToggle($event)"
                @isLoadingTrue="loadingToggle($event)"
                @isLoadingFalse="loadingToggle($event)"
                @errorMessages="errorUpload($event)"
            />
            <LoadingComponent v-show="isLoading"
            />
            <ErrorDialog v-show="uploadError != 0"
                :error-messages="uploadError"
            />
        </template>
    </BaseLayout>
</template>

<script>
import BaseLayout from './BaseLayout.vue';
import TabelSiswa from '../../components/admin/TabelSiswa.vue';
import FormCreateSiswa from '../../components/admin/FormCreateSiswa.vue';
import FormEditSiswa from '../../components/admin/FormEditSiswa.vue';
import DeleteDialogSiswa from '../../components/admin/DeleteDialogSiswa.vue';
import FormUploadSiswa from '../../components/admin/FormUploadSiswa.vue';
import LoadingComponent from '../../components/admin/LoadingComponent.vue';
import ErrorDialog from '../../components/admin/ErrorDialog.vue';
import axios from 'axios';

export default {
    data() {
        return {
            token: localStorage.getItem("auth_token"),
            dataKelas: [],
            dataSiswa: [],
            isFormUploadSiswa: false,
            uploadError: [],
            isFormCreateSiswa: false,
            dataDelete: [],
            isDeleteDialog: false,
            dataUpdate: [],
            isFormEditSiswa: false,
            isLoading: false,
        }
    },
    components: {
        BaseLayout,
        TabelSiswa,
        FormCreateSiswa,
        FormEditSiswa,
        DeleteDialogSiswa,
        FormUploadSiswa,
        LoadingComponent,
        ErrorDialog,
    },
    mounted() {
        this.getKelas();
    },
    methods: {
        getKelas() {
            axios.get("/api/admin/kelas", {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
                    this.dataKelas = data.data;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        setDataSiswa(value){
            this.dataSiswa = value;
        },
        setDeleteSiswa(id) {
            const data = JSON.parse(JSON.stringify(this.dataSiswa));
            const index = data.findIndex((item) => item.id === id);
            this.dataDelete = data[index];
        },
        setUpdateSiswa(id) {
            const data = JSON.parse(JSON.stringify(this.dataSiswa));
            const index = data.findIndex((item) => item.id === id);
            this.dataUpdate = data[index];
        },
        formCreateSiswaToggle(value){
            this.isFormCreateSiswa = value;
        },
        formEditSiswaOpen(value){
            this.setUpdateSiswa(value.id);
            this.isFormEditSiswa = value.status;
        },
        formEditSiswaClose(value){
            this.isFormEditSiswa = value;
        },
        deleteDialogSiswaOpen(value){
            this.setDeleteSiswa(value.id);
            this.isDeleteDialog = value.status;
        },
        deleteDialogSiswaClose(value){
            this.isDeleteDialog = value;
        },

        formUploadSiswaToggle(value){
            this.isFormUploadSiswa = value;
        },

        loadingToggle(value){
            this.isLoading = value;
        },

        errorUpload(value){
            this.uploadError = value;
        }

    }
}
</script>