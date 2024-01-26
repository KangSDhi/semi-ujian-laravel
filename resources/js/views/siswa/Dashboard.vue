<template>
    <BaseLayout>
        <template #content>
            <div class="py-5">
                <h1 class="text-4xl font-sans font-bold">Mata Ujian</h1>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div v-for="(item, index) in soal">
                    <div class="max-w-sm rounded overflow-hidden shadow-lg">
                        <img class="w-full"
                            src="https://cdn.shopify.com/s/files/1/0088/3726/7552/files/k_12_school_testing_a20846a4-d028-484b-94c0-262cd000737e_2048x2048.jpg?v=1583767177"
                            alt="Sunset in the mountains">
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{ item.nama_soal }}</div>
                            <p class="text-gray-700 text-base">
                                {{ item.waktu_mulai }}
                            </p>
                        </div>
                        <div class="px-6 pt-4 pb-2 mb-3">
                            <template v-if="Date.now() >= Date.parse(item.waktu_mulai)">
                                <a :href="item.link" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Mulai
                                </a>
                            </template>
                            <template v-else>
                                <a href="#" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Belum Mulai
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </BaseLayout>
</template>

<script>
import axios from 'axios';
import BaseLayout from './BaseLayout.vue';

export default {
    data() {
        return {
            token: localStorage.getItem("auth_token"),
            soal: [],
        }
    },
    components: {
        BaseLayout
    },
    mounted() {
        this.getSoal()
    },
    methods: {
        getSoal() {
            axios.get("/api/siswa/soal/user", {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
                    console.log(data);
                    this.soal = data.data;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        }
    }
}
</script>