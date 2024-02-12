<template>
    <BaseLayout>
        <template #content>
            <Bar 
                v-if="chartSiswaTotalTingkatJurusan.loaded" 
                :options="chartSiswaTotalTingkatJurusan.chartOptions" 
                :data="chartSiswaTotalTingkatJurusan.chartData" />
        </template>
    </BaseLayout>
</template>

<script>
import BaseLayout from './BaseLayout.vue';
import axios from 'axios';
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Colors, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, Colors, BarElement, CategoryScale, LinearScale)


export default {
    data() {
        return {
            token: localStorage.getItem("auth_token"),
            chartSiswaTotalTingkatJurusan: {
                loaded: false,
                chartData: {
                    labels: [],
                    datasets: [{
                        label: 'Chart Data Siswa',
                        data: [],
                        backgroundColor: [],
                    }]
                },
                chartOptions: {
                    responsive: true,
                }
            }
        }
    },
    components: {
        BaseLayout,
        Bar,
    },
    mounted() {
        this.getChartTotalSiswa();
    },
    methods: {
        getChartTotalSiswa() {
            axios.get("/api/admin/chart/siswa/total/tingkat/jurusan", {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
                .then(({ data }) => {
                    const response = data.data;
                    let label = [];
                    let total = [];
                    let backgroudColor = [];

                    response.forEach(function (element, index, array) {
                        label.push(array[index].nama_tingkat + "-" + array[index].nama_jurusan);
                        total.push(array[index].total);
                    });

                    for (let index = 0; index < total.length; index++) {
                        backgroudColor.push(this.getRandomRGBA());
                    }

                    this.chartSiswaTotalTingkatJurusan.chartData.labels = label;
                    this.chartSiswaTotalTingkatJurusan.chartData.datasets[0].data = total;
                    this.chartSiswaTotalTingkatJurusan.chartData.datasets[0].backgroundColor = backgroudColor;

                    this.chartSiswaTotalTingkatJurusan.loaded = true;

                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        getRandomRGBA() {
            return 'rgba(' + this.getRandomInt(256) + ',' + this.getRandomInt(256) + ',' + this.getRandomInt(256) + ', 0.5)';
        },
        getRandomInt(max) {
            return Math.floor(Math.random() * max);
        }

    }
}
</script>