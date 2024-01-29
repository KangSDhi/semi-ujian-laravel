<template>
    <RouterView></RouterView>
</template>

<script>
export default {
    name: 'Root',
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = to.meta.title || 'LMS Ujian';
            }
        }
    }
}
</script>