<template>
    <BaseLayout>
        <template #content>
            <div class="grid grid-cols-2">
                <TabelTingkat class="p-1"
                              @data-tingkat="setDataTingkat($event)"
                              @is-form-to-make-tingkat-true="formCreateTingkatToggle($event)"
                              @is-form-to-edit-tingkat-true="formEditTingkatOpen($event)"
                              @is-dialog-to-delete-tingkat-true="deleteDialogTingkatOpen($event)"/>
                <FormCreateTingkat v-show="isFormToMakeTingkat"
                                   :token="token"
                                   @is-form-to-make-tingkat-false="formCreateTingkatToggle($event)"/>
                <FormEditTingkat v-show="isFormToEditTingkat"
                                 :token="token"
                                 :data-update="dataUpdateTingkat"
                                 @is-form-to-edit-tingkat-false="formEditTingkatClose($event)"/>
                <DeleteDialogTingkat v-show="isDeleteDialogTingkat"
                                     :token="token"
                                     :data-delete="dataDeleteTingkat"
                                     @is-dialog-to-delete-tingkat-false="deleteDialogTingkatClose($event)"/>
                <TabelJurusan class="p-1"
                              @data-jurusan="setDataJurusan($event)"
                              @is-form-to-make-jurusan-true="formToMakeJurusanToggle($event)"
                              @is-form-to-edit-jurusan-true="formToEditJurusanOpen($event)"
                              @isDialogToDeleteJurusanTrue="dialogToDeleteJurusanOpen($event)"/>
                <FormCreateJurusan v-show="isFormToMakeJurusan"
                                   :token="token"
                                   @is-form-to-make-jurusan-false="formToMakeJurusanToggle($event)"/>
                <FormEditJurusan v-show="isFormToEditJurusan"
                                 :token="token"
                                 :data-update="dataUpdateJurusan"
                                 @is-form-to-edit-jurusan-false="formToEditJurusanClose($event)"/>
                <DeleteDialogJurusan v-show="isDeleteDialogJurusan"
                                     :token="token"
                                     :data-delete="dataDeleteJurusan"
                                     @is-dialog-to-delete-jurusan-false="dialogToDeleteJurusanClose($event)"/>
            </div>
        </template>
    </BaseLayout>
</template>

<script>
import BaseLayout from "./BaseLayout.vue";
import TabelTingkat from "../../components/admin/TabelTingkat.vue";
import FormCreateTingkat from "../../components/admin/FormCreateTingkat.vue";
import FormEditTingkat from "../../components/admin/FormEditTingkat.vue";
import DeleteDialogTingkat from "../../components/admin/DeleteDialogTingkat.vue";
import TabelJurusan from "../../components/admin/TabelJurusan.vue";
import FormCreateJurusan from "../../components/admin/FormCreateJurusan.vue";
import FormEditJurusan from "../../components/admin/FormEditJurusan.vue";
import DeleteDialogJurusan from "../../components/admin/DeleteDialogJurusan.vue";

export default {
    data() {
        return {
            token: localStorage.getItem("auth_token"),
            dataTingkat: [],
            isFormToMakeTingkat: false,
            isFormToEditTingkat: false,
            dataUpdateTingkat: [],
            isDeleteDialogTingkat: false,
            dataDeleteTingkat: [],
            dataJurusan: [],
            isFormToMakeJurusan: false,
            isFormToEditJurusan: false,
            dataUpdateJurusan: [],
            isDeleteDialogJurusan: false,
            dataDeleteJurusan: []
        }
    },
    components: {
        BaseLayout,
        TabelTingkat,
        FormCreateTingkat,
        FormEditTingkat,
        DeleteDialogTingkat,
        TabelJurusan,
        FormCreateJurusan,
        FormEditJurusan,
        DeleteDialogJurusan
    },
    methods: {
        setDataTingkat(value) {
            this.dataTingkat = value;
        },
        formCreateTingkatToggle(value) {
            this.isFormToMakeTingkat = value;
        },
        setUpdateTingkat(id) {
            const data = JSON.parse(JSON.stringify(this.dataTingkat));
            const index = data.findIndex((item) => item.id === id);
            this.dataUpdateTingkat = data[index];
        },
        formEditTingkatOpen(value) {
            this.setUpdateTingkat(value.id);
            this.isFormToEditTingkat = value.status;
        },
        formEditTingkatClose(value) {
            this.isFormToEditTingkat = value;
        },
        setDeleteTingkat(id) {
            const data = JSON.parse(JSON.stringify(this.dataTingkat));
            const index = data.findIndex((item) => item.id === id);
            this.dataDeleteTingkat = data[index];
        },
        deleteDialogTingkatOpen(value) {
            this.setDeleteTingkat(value.id);
            this.isDeleteDialogTingkat = value.status;
        },
        deleteDialogTingkatClose(value) {
            this.isDeleteDialogTingkat = value;
        },
        setDataJurusan(value) {
            this.dataJurusan = value;
        },
        formToMakeJurusanToggle(value) {
            this.isFormToMakeJurusan = value;
        },
        setUpdateJurusan(id) {
            const data = JSON.parse(JSON.stringify(this.dataJurusan));
            const index = data.findIndex((item) => item.id === id);
            this.dataUpdateJurusan = data[index];
        },
        formToEditJurusanOpen(value) {
            this.setUpdateJurusan(value.id);
            this.isFormToEditJurusan = value.status;
        },
        formToEditJurusanClose(value) {
            this.isFormToEditJurusan = value;
        },
        setDeleteJurusan(id) {
            const data = JSON.parse(JSON.stringify(this.dataJurusan));
            const index = data.findIndex((item) => item.id === id);
            this.dataDeleteJurusan = data[index];
        },
        dialogToDeleteJurusanOpen(value) {
            this.setDeleteJurusan(value.id);
            this.isDeleteDialogJurusan = value.status;
        },
        dialogToDeleteJurusanClose(value) {
            this.isDeleteDialogJurusan = value;
        }
    }
}
</script>
