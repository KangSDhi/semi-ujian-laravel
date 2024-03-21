<template>
    <BaseLayout>
        <template #content="contentProps">
            <div class="flex items-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <h2 class="text-1xl font-sans font-semibold">{{ contentProps.nama }}</h2>
            </div>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                </svg>
                <h2 class="text-1xl font-sans font-semibold">{{ contentProps.kelas }}</h2>
            </div>
            <div class="py-5">
                <h1 class="text-4xl font-sans font-bold">Mata Ujian</h1>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div v-for="(item, index) in soal">
                    <template v-if="waktuHariIni != 0">
                        <KartuSoal :item="item" :time="waktuHariIni" />
                    </template>
                </div>
            </div>
        </template>
    </BaseLayout>
</template>

<script>
import axios from 'axios';
import BaseLayout from './BaseLayout.vue';
import KartuSoal from '../../components/siswa/KartuSoal.vue';

export default {
    data() {
        return {
            token: localStorage.getItem("auth_token"),
            soal: [],
            waktuHariIni: 0
        }
    },
    components: {
        BaseLayout,
        KartuSoal,
    },
    mounted() {
        this.getSoal(),
        this.getTimeApi(),
        this.checkTimeGMT7()
    },
    methods: {
        getSoal() {
            axios.get("/api/siswa/soal/user", {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
                    this.soal = data.data;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        getTimeApi(){
            axios.get("https://worldtimeapi.org/api/timezone/Asia/Jakarta")
                .then(({ data }) => {
                    const date = new Date(data.datetime);

                    const milliseconds = date.getTime();

                    this.waktuHariIni = milliseconds;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        checkTimeGMT7(){
            const currentDate = new Date();

            const currtntTimeZoneOffset = currentDate.getTimezoneOffset();

            const gmtPlus7Offset = -7 * 60;

            if (currtntTimeZoneOffset !== gmtPlus7Offset) {
                localStorage.removeItem("auth_token");
                this.$router.push({ name: "Login Page" });
            }
        }
    }
}
</script>