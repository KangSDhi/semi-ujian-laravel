import LoginPage from "../views/auth/Login.vue";
import DashboardSiswaPage from "../views/siswa/Dashboard.vue";

const routes = [
    {
        path: "/",
        name: "Login Page",
        component: LoginPage,
        meta: {
            title: "Halaman Login"
        }
    },
    {
        path: "/siswa/",
        children: [
            {
                path: "dashboard",
                name: "Dashboard Siswa",
                component: DashboardSiswaPage,
                meta: {
                    title: "Dashboard Siswa"
                }
            }
        ]
    }
];

export default routes;