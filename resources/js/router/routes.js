import LoginPage from "../views/auth/Login.vue";

const routes = [
    {
        path: "/",
        name: "Login Page",
        component: LoginPage,
        meta: {
            title: "Halaman Login"
        }
    }
];

export default routes;