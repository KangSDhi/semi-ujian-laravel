<template>
    <button
        class="px-5 py-2 h-10 justify-self-center bg-green-200 dark:bg-green-400 hover:bg-green-300 dark:hover:bg-green-500 text-sm me-2 rounded-lg inline-flex items-center"
        @click="exportXLSX">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
        Export Excel
    </button>
</template>

<script>
import { utils, writeFileXLSX } from "xlsx";
export default {
    name: "ButtonExportExcel",
    props: {
        dataSiswa: {
            type: Array
        }
    },
    methods: {
        exportXLSX() {
            const data = JSON.parse(JSON.stringify(this.dataSiswa));
            this.removeColumn(data, "id");
            this.changeColumnTitle(data, "nisn", "NISN");
            this.changeColumnTitle(data, "nama_siswa", "Nama Siswa");
            this.changeColumnTitle(data, "nama_kelas", "Kelas");
            this.changeColumnTitle(data, "password_dec", "Password");
            let columnWidths = this.autoSizeColumns(data);
            console.log(columnWidths['Kelas']);
            let wscols = [
                {wch:columnWidths['NISN']},
                {wch:columnWidths['Nama Siswa']},
                {wch:columnWidths['Kelas']},
                {wch:columnWidths['Password']},
            ];
            const ws = utils.json_to_sheet(data);
            ws['!cols'] = wscols;
            const wb = utils.book_new();
            utils.book_append_sheet(wb, ws, "Data");
            writeFileXLSX(wb, "DataSiswa.xlsx");
        },
        removeColumn(jsonData, columnName) {
            jsonData.forEach(function (row) {
                delete row[columnName];
            });
        },
        changeColumnTitle(jsonData, oldTitle, newTitle) {
            jsonData.forEach(function (row) {
                row[newTitle] = row[oldTitle];
                delete row[oldTitle];
            })
        },
        autoSizeColumns(jsonData) {
            let wscols = [];
            jsonData.forEach(function (row) {
                Object.keys(row).forEach(function (key) {
                    var width = (row[key].toString().length + 2) * 1.2; // Adjust as needed
                    if (!wscols[key] || wscols[key] < width) {
                        wscols[key] = width;
                    }
                });
            });
            return wscols;
        },
    }
}
</script>