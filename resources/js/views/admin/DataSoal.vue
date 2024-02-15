<template>
    <BaseLayout>
        <template #content>
            <TabelSoal 
                @dataSoal="setDataSoal($event)"
                @isFormCreateSoalTrue="formCreateSoalToggle($event)"
                @isFormEditSoalTrue="formEditSoalOpen($event)"
                @isDeleteDialogSoalTrue="deleteDialogSoalOpen($event)"
            />
            <FormCreateSoal v-show="isFormCreateSoal" 
                :token="token" 
                :data-jurusan="dataJurusan" 
                :data-tingkat="dataTingkat" 
                @isFormCreateSoalFalse="formCreateSoalToggle($event)"
                @isLoadingTrue="loadingToggle($event)"
                @isLoadingFalse="loadingToggle($event)"
            />
            <FormEditSoal v-show="isFormEditSoal"
                :token="token"
                :data-update="dataUpdate"
                :data-jurusan="dataJurusan"
                :data-tingkat="dataTingkat"
                @isFormEditSoalFalse="formEditSoalClose($event)"
                @isLoadingTrue="loadingToggle($event)"
                @isLoadingFalse="loadingToggle($event)"
            />
            <DeleteDialogSoal v-show="isDeleteDialog"
                :token="token"
                :data-delete="dataDelete"
                @isDeleteDialogSoalFalse="deleteDialogSoalClose($event)"
                @isLoadingTrue="loadingToggle($event)"
                @isLoadingFalse="loadingToggle($event)"
            />
            <LoadingComponent v-show="isLoading"/>
        </template>
    </BaseLayout>
</template>

<script>
import BaseLayout from './BaseLayout.vue';
import FormCreateSoal from '../../components/admin/FormCreateSoal.vue';
import FormEditSoal from '../../components/admin/FormEditSoal.vue';
import DeleteDialogSoal from '../../components/admin/DeleteDialogSoal.vue';
import TabelSoal from '../../components/admin/TabelSoal.vue';
import LoadingComponent from '../../components/admin/LoadingComponent.vue';
import axios from 'axios';

export default {
    data() {
        return {
            token: localStorage.getItem("auth_token"),
            dataSoal: [],
            dataJurusan: [],
            dataTingkat: [],
            isFormCreateSoal: false,
            isDeleteDialog: false,
            dataDelete: [],
            isFormEditSoal: false,
            dataUpdate: [],
            isLoading: false,
        }
    },
    components: {
        BaseLayout,
        TabelSoal,
        FormCreateSoal,
        FormEditSoal,
        DeleteDialogSoal,
        LoadingComponent,
    },
    mounted() {
        this.getJurusan();
        this.getTingkat();
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
        getTingkat(){
            axios.get("/api/admin/tingkat", {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
                    this.dataTingkat = data.data;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        setDataSoal(value){
            this.dataSoal = value;
        },
        setDeleteData(id) {
            const data = JSON.parse(JSON.stringify(this.dataSoal));
            const index = data.findIndex((item) => item.id === id);
            this.dataDelete = data[index];
        },
        setUpdateData(id) {
            const data = JSON.parse(JSON.stringify(this.dataSoal));
            const index = data.findIndex((item) => item.id === id);
            this.dataUpdate = data[index];
        },
        formCreateSoalToggle(value){
            this.isFormCreateSoal = value;
        },
        formEditSoalOpen(value){
            this.setUpdateData(value.id);
            this.isFormEditSoal = value.status;
        },
        formEditSoalClose(value){
            this.isFormEditSoal = value;
        },
        deleteDialogSoalOpen(value){
            this.setDeleteData(value.id);
            this.isDeleteDialog = value.status;
        },
        deleteDialogSoalClose(value){
            this.isDeleteDialog = value;
        },
        loadingToggle(value){
            this.isLoading = value;
        },
    }
}
</script>