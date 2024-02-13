<template>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        <img class="w-full"
            src="https://cdn.shopify.com/s/files/1/0088/3726/7552/files/k_12_school_testing_a20846a4-d028-484b-94c0-262cd000737e_2048x2048.jpg?v=1583767177"
            alt="Sunset in the mountains">
        <div class="px-6 py-4">
            <h2 class="font-bold text-xl mb-2">{{ item.nama_soal }}</h2>
            <h3 class="font-semibold text-md">Waktu Mulai</h3>
            <p class="text-gray-700 text-base">
                {{ changeFormatDate(item.waktu_mulai) }}
            </p>
            <h3 class="font-semibold text-md mt-1">Waktu Selesai</h3>
            <p class="text-gray-700 text-base">
                {{ changeFormatDate(item.waktu_selesai) }}
            </p>
        </div>
        <div class="px-6 pt-4 pb-2 mb-3">
            <template v-if="Date.now() >= Date.parse(item.waktu_mulai) && Date.now() <= Date.parse(item.waktu_selesai)">
                <a :href="item.link" target="_blank"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Mulai
                </a>
            </template>
            <template v-else-if="Date.now() >= Date.parse(item.waktu_mulai) && Date.now() >= Date.parse(item.waktu_selesai)">
                <a href="#" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Sudah Selesai
                </a>
            </template>
            <template v-else>
                <a href="#" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Belum Mulai
                </a>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    name: "KartuSoal",
    props: {
        item: {
            type: Object
        }
    },
    methods: {
        changeFormatDate(dateStr){
            const inputDate = new Date(dateStr);

            const year = inputDate.getFullYear();
            const month = ('0' + (inputDate.getMonth() + 1)).slice(-2);
            const day = ('0' + inputDate.getDate()).slice(-2);
            const hours = ('0' + inputDate.getHours()).slice(-2);
            const minutes = ('0' + inputDate.getMinutes()).slice(-2);
            const seconds = ('0' + inputDate.getSeconds()).slice(-2);

            const formattedDateStr = day + '-' + month + '-' + year + ' ' + hours + ':' + minutes + ':' + seconds;

            return formattedDateStr;
        }
    }
}
</script>