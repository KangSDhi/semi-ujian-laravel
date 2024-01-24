<template>
    <div>
        <header></header>
        <section>
            <main class="mx-auto max-w-screen-md py-12">
                <slot name="content"></slot>
            </main>
        </section>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data(){
        return {
            token: localStorage.getItem("auth_token"),
        }
    },
    mounted(){
        this.checkAuth()
    },
    methods: {
        checkAuth(){
            axios.get("/api/check/auth", {
                headers: {
                    "Authorization": "Bearer " + this.token
                }
            })
            .then(({ data }) => {
                if (data.data.role_id == 1) {
                    this.$router.push({ name: "Dashboard Admin" });
                }
                
                if (data.data.role_id == 2) {
                    this.$router.push({ name: "Dashboard Siswa" });
                }
            })
            .catch(({ response }) => {
                console.error(response.status);
            });
        }
    }
}
</script>