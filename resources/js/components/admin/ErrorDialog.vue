<template>
    <div class="bg-slate-800 bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
        <div class="bg-white px-16 py-14 rounded-md">
            <h1 class="text-2xl mb-4 font-bold text-red-500">Error!</h1>
            <div class="flex flex-col">
                <template v-for="(item, index) in uploadError">
                    <span class="text-red-500 text-xl font-semibold">{{ '* ' + item }}</span>
                </template>
            </div>
            <div class="flex justify-end mt-4">
                <button @click="this.$router.go()"
                    class="bg-gray-400 px-3 py-2 rounded-lg text-md">Tutup</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ErrorDialog",
    props: {
        uploadError: {
            type: Array
        }
    },
}
</script>