<template>
    <BaseLayout>
        <template #content>
            <TabelKelas @data-kelas="setDataKelas($event)"
                        @is-form-to-make-kelas-true="formCreateKelasToggle($event)"
                        @is-form-to-edit-kelas-true="formEditKelasOpen($event)"
                        @is-dialog-to-delete-kelas-true="dialogDeleteKelasOpen($event)"/>
            <FormCreateKelas v-show="isFormToMakeKelas"
                             :token="token"
                             :data-tingkat="dataTingkat"
                             :data-jurusan="dataJurusan"
                             @is-form-to-make-kelas-false="formCreateKelasToggle($event)"/>
            <FormEditKelas v-show="isFormToEditKelas"
                           :token="token"
                           :data-tingkat="dataTingkat"
                           :data-jurusan="dataJurusan"
                           :data-update="dataUpdateKelas"
                           @is-form-to-edit-kelas-false="formEditKelasClose($event)"/>
            <DeleteDialogKelas v-show="isDeleteDialogKelas"
                               :token="token"
                               :data-delete="dataDeleteKelas"
                               @is-dialog-to-delete-kelas-false="dialogDeleteKelasClose($event)"/>
        </template>
    </BaseLayout>
</template>

<script>
import BaseLayout from "./BaseLayout.vue";
import TabelKelas from "../../components/admin/TabelKelas.vue";
import FormCreateKelas from "../../components/admin/FormCreateKelas.vue";
import FormEditKelas from "../../components/admin/FormEditKelas.vue";
import DeleteDialogKelas from "../../components/admin/DeleteDialogKelas.vue";
import axios from "axios";

export default {
    data() {
        return {
            token: localStorage.getItem("auth_token"),
            dataTingkat: [],
            dataJurusan: [],
            dataKelas: [],
            isFormToMakeKelas: false,
            isFormToEditKelas: false,
            dataUpdateKelas: [],
            isDeleteDialogKelas: false,
            dataDeleteKelas: [],
        }
    },
    components: {
        BaseLayout,
        TabelKelas,
        FormCreateKelas,
        FormEditKelas,
        DeleteDialogKelas
    },
    mounted() {
        this.loadTingkat();
        this.loadJurusan();
    },
    methods: {
        loadTingkat() {
            axios.get("/api/admin/tingkat", {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            }).then(({data}) => {
                console.log(data);
                this.dataTingkat = data.data;
            }).catch(({response}) => {
                console.error(response)
            })
        },
        loadJurusan() {
            axios.get("/api/admin/jurusan", {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            }).then(({data}) => {
                console.log(data);
                this.dataJurusan = data.data;
            }).catch(({response}) => {
                console.error(response);
            });
        },
        setDataKelas(value) {
            this.dataKelas = value;
        },
        formCreateKelasToggle(value) {
            this.isFormToMakeKelas = value;
        },
        setUpdateKelas(id) {
            const data = JSON.parse(JSON.stringify(this.dataKelas));
            const index = data.findIndex((item) => item.id === id);
            this.dataUpdateKelas = data[index];
        },
        formEditKelasOpen(value) {
            this.setUpdateKelas(value.id);
            this.isFormToEditKelas = value.status;
        },
        formEditKelasClose(value) {
            this.isFormToEditKelas = value;
        },
        setDeleteKelas(id) {
            const data = JSON.parse(JSON.stringify(this.dataKelas));
            const index = data.findIndex((item) => item.id === id);
            this.dataDeleteKelas = data[index];
        },
        dialogDeleteKelasOpen(value) {
            this.setDeleteKelas(value.id);
            this.isDeleteDialogKelas = value.status;
        },
        dialogDeleteKelasClose(value) {
            this.isDeleteDialogKelas = value;
        }
    }
}
</script>
