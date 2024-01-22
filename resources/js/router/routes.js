import LoginPage from "../views/auth/Login.vue";
import DashboardSiswaPage from "../views/siswa/Dashboard.vue";
import DashboardAdminPage from "../views/admin/Dashboard.vue";
import DataSiswaAdminPage from "../views/admin/DataSiswa.vue";

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
        path: "/admin/",
        children: [
            {
                path: "dashboard",
                name: "Dashboard Admin",
                component: DashboardAdminPage,
                meta: {
                    title: "Dashboard Admin"
                }
            },
            {
                path: "data-siswa",
                name: "Data Siswa Admin",
                component: DataSiswaAdminPage,
                meta: {
                    title: "Data Siswa"
                }
            }
        ]
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