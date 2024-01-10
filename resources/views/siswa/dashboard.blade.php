@extends('siswa.base')

@section('title', $title)

@section('content')
    <div x-data="data()" x-init="initData()" class="grid grid-cols-4 gap-4">
        <template x-for="(item, index) in data" :key="index">
            <div class="max-w-sm rounded overflow-hidden shadow-lg">
                <img class="w-full"
                    src="https://cdn.shopify.com/s/files/1/0088/3726/7552/files/k_12_school_testing_a20846a4-d028-484b-94c0-262cd000737e_2048x2048.jpg?v=1583767177"
                    alt="Sunset in the mountains">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2"><span x-text="item.nama_soal"></span></div>
                    <p class="text-gray-700 text-base">
                        <span x-text="item.waktu_mulai"></span>
                    </p>
                </div>
                <div class="px-6 pt-4 pb-2 mb-3">
                    <template x-if="Date.now() >= Date.parse(item.waktu_mulai)">
                        <a :href="item.link" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Mulai
                        </a>

                    </template>
                    <template x-if="Date.now() <= Date.parse(item.waktu_mulai)">
                        <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Belum Mulai
                        </button>
                    </template>
                </div>
            </div>
        </template>
    </div>
@endsection

@push('script')
    <script>
        const data = () => {
            return {
                token: localStorage.getItem('web_token'),
                data: [],
                initData() {
                    async function fetchData() {
                        try {
                            const {
                                data
                            } = await axios.get('{{ route('siswa.get.soal') }}', {
                                headers: {
                                    'Authorization': 'Bearer ' + localStorage.getItem('web_token')
                                }
                            });
                            return data.data;
                        } catch (error) {
                            return error;
                        }
                    }

                    fetchData()
                        .then(data => {
                            console.log(data);
                            this.data = data;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            }
        }
    </script>
@endpush
