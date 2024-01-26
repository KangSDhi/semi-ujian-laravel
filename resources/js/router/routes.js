import LoginPage from "../views/auth/Login.vue";
import DashboardSiswaPage from "../views/siswa/Dashboard.vue";
import DashboardAdminPage from "../views/admin/Dashboard.vue";
import DataSiswaAdminPage from "../views/admin/DataSiswa.vue";
import DataSoalAdminPage from "../views/admin/DataSoal.vue";

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
            },
            {
                path: "data-soal",
                name: "Data Soal Admin",
                component: DataSoalAdminPage,
                meta: {
                    title: "Data Soal"
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